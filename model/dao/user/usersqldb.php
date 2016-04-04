<?php

/**
 * UserSqlDB
 * This is a class that handles user SQL database functions
 * @package dao
 * @subpackage dao.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserSqlDB extends SqlSuper implements UserDao {

    /**
     * The user dist db handles user related db functions
     * @var UserDistDao
     */
    private $_userDistDB;

    /**
     * The notification db handles notification related db functions
     * @var NotificationDao
     */
    private $_notificationDB;

    public function __construct($host, $username, $passwd, $database) {
        parent::__construct('mysql:host=' . $host, $username, $passwd, $database);
        $this->init($host, $username, $passwd, $database);
    }

    private function init($host, $username, $passwd, $database) {
        $this->_userDistDB = new UserDistSqlDB($host, $username, $passwd, $database);
        $this->_notificationDB = new NotificationSqlDB($host, $username, $passwd, $database);
    }

    /**
     * add
     * Adds a user to 
     * @param UserDetailed $user
     * @throws DBException
     */
    public function add(DaoObject $user) {
        if (!$user instanceof UserDetailed) {
            throw new DBException('The object you tried to add was not a user object', NULL);
        }
        if (parent::containsId($user->getId(), 'user')) {
            throw new DBException('The database already contains a user with this id', NULL);
        }
        if (!$this->emailAvailable($user->getEmail())) {
            throw new DBException('This email is already in use. Make sure you did not already create an account');
        }
        if (!$this->usernameAvailable($user->getUsername())) {
            throw new DBException('Very sad to inform you that this username is already taken.');
        }
        $query = 'INSERT INTO ' . Globals::getTableName('user') . ' (user_roles_user_role_id, avatars_avatar_id, user_name, user_hash_salt, user_email, user_karma, user_reg_key, user_warnings, user_diamonds, preference_datetime_format, user_created, last_login, donated_amount, active_seconds)';
        $query .= 'VALUES(:user_role_id, :avatar_id, :username, :pw, :email, :karma, :reg_key, :warnings, :diamonds, :date_pref, :created, :last_login, :donated, :active);';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':user_role_id' => $user->getUserRole()->getId(),
            ':avatar_id' => $user->getAvatar()->getId(),
            ':username' => $user->getUsername(),
            ':pw' => $user->getPwEncrypted(),
            ':email' => $user->getEmail(),
            ':karma' => $user->getKarma(),
            ':reg_key' => $user->getRegKey(),
            ':warnings' => $user->getWarnings(),
            ':diamonds' => $user->getDiamonds(),
            ':date_pref' => $user->getDateTimePref(),
            ':created' => $user->getCreatedStr(Globals::getDateTimeFormat('mysql', true)),
            ':last_login' => $user->getLastLoginStr(Globals::getDateTimeFormat('mysql', true)),
            ':donated' => $user->getDonated(),
            ':active' => $user->getActiveTime()
        );
        $statement->execute($queryArgs);
    }

    /**
     * emailAvailable
     * Checks if an email is already in use on the site
     * @param string $mail
     * @return bool
     */
    public function emailAvailable($mail) {
        $userT = Globals::getTableName('user');
        $query = 'SELECT ' . $userT . '.user_email FROM ' . $userT . ' WHERE user_email=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $mail);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return count($result) < 1;
    }

    /**
     * usernameAvailable
     * Checks if a username is already in use on the site
     * @param string $username
     * @return bool
     */
    public function usernameAvailable($username) {
        $userT = Globals::getTableName('user');
        $query = 'SELECT ' . $userT . '.user_name FROM ' . $userT . ' WHERE user_name=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $username);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return count($result) < 1;
    }

    /**
     * remove
     * Removes a user from the database
     * @param int $id the user id
     */
    public function remove($id) {
        parent::triggerIdNotFound($id, 'user');
        $query = 'DELETE FROM ' . Globals::getTableName('user') . ' WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

    /**
     * get
     * Returns the user with this id from the database as a user object
     * @param int $id
     * @return UserDetailed $user
     * @throws DBException if the no user with this id was found
     */
    public function get($id) {
        parent::triggerIdNotFound($id, 'user');
        $query = 'SELECT * FROM ' . Globals::getTableName('user') . ' WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $row = $result[0];
        $avatar = $this->getAvatar($row['avatars_avatar_id']);
        $userRole = $this->getUserRole($row['user_roles_user_role_id']);
        $userSimple = $this->createUserSimple($row, $avatar, $userRole);
        $recentNotifications = $this->getNotifications($id, 10);
        $lastComment = $this->getLastComment($userSimple);
        $achievements = $this->getAchievements($id);
        $user = $this->createUserDetailed($userSimple, $row, $recentNotifications, $lastComment, $achievements);
        return $user;
    }

    /**
     * getByString
     * Returns a user by searching for it's username or email
     * @param string $identifier being the username or the email of a user
     * @return UserDetailed
     * @throws DBException if no users with this username or email exists
     */
    public function getByString($identifier) {
        try {
            $query = 'SELECT * FROM ' . Globals::getTableName('user') . ' WHERE user_name = ? OR user_email = ?';
            $statement = parent::prepareStatement($query);
            $statement->bindParam(1, $identifier);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            $user = $this->createUser($row, true);
            return $user;
        } catch (PDOException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
        //should never be reached because exception
        return null;
    }

    /**
     * getUsers
     * Returns all users in the database
     * @return array of UserSimple objects
     */
    public function getUsers() {
        $query = 'SELECT user_id, user_roles_user_role_id, avatars_avatar_id, user_name , donated_amount FROM ' . Globals::getTableName('user');
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $users = array();
        foreach ($result as $row) {
            $avatar = $this->getAvatar($row['avatars_avatar_id']);
            $userRole = $this->getUserRole($row['user_roles_user_role_id']);
            $user = parent::getCreationHelper()->createUserSimple($row, $avatar, $userRole);
            $users[$user->getId()] = $user;
        }
        return $users;
    }

    /**
     * getSimple
     * returns a UserSimple object with id when no detailed information is needed
     * @param int $id
     * @return UserSimple 
     * @throws DBException if no user with this id was found
     */
    public function getSimple($id) {
        $result = $this->getSimpleUserResult($id)['0'];
        if (!$result || empty($result)) {
            throw new DBException('could not find a user with this id. id was: ' . $id, NULL);
        }
        $avatar = $this->getAvatar($result['avatars_avatar_id']);
        $userRole = $this->getUserRole($result['user_roles_user_role_id']);
        $user = parent::getCreationHelper()->createUserSimple($result, $avatar, $userRole);
        return $user;
    }

    /**
     * updatePw
     * updates the password for a user with this id
     * @param int $userId
     * @param string $pwNew as new encrypted password
     */
    public function updatePw($userId, $pwNew) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET user_hash_salt = :pw WHERE users.user_id = :id';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':pw' => $pwNew,
            ':id' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserDonated
     * updates the amount donated for the user with this id
     * @param int $userId
     * @param int $donated total amount
     */
    public function updateUserDonated($userId, $donated) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.donated_amount = :donated WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':donated' => $donated,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserKarma
     * udpates the karma of the user to a new amount
     * @param int $userId
     * @param int $newAmount of karma total
     */
    public function updateUserKarma($userId, $newAmount) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.user_karma = :karma WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':karma' => $newAmount,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserRegKey
     * Updates the reg key for user with this id
     * @param int $userId
     * @param string $regKey
     */
    public function updateUserRegKey($userId, $regKey) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.user_reg_key = :regkey WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':regkey' => $regKey,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserWarnings
     * Updates the amount of warnings for user with this id
     * @param int $userId
     * @param int $warnings total amount
     */
    public function updateUserWarnings($userId, $warnings) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.user_warnings = :warnings WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':warnings' => $warnings,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserDiamonds
     * updates the amount of diamonds for user with this id
     * @param int $userId
     * @param int $diamonds total amount
     */
    public function updateUserDiamonds($userId, $diamonds) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.user_diamonds = :diamonds WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':diamonds' => $diamonds,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserDateTimePref
     * Updates the time preference setting for the user with this id
     * @param int $userId
     * @param string $dateTimePref
     */
    public function updateUserDateTimePref($userId, $dateTimePref) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.preference_datetime_format = :dateTime WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':dateTime' => $dateTimePref,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserLastLogin
     * Updates the last login time of the user with this id
     * @param int $userId
     * @param DateTime $lastLogin
     */
    public function updateUserLastLogin($userId, DateTime $lastLogin) {
        $lastLoginSql = $lastLogin->format(Globals::getDateTimeFormat('mysql', true));
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.last_login = :lastLogin WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':lastLogin' => $lastLoginSql,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateUserActiveTime
     * Updates the total seconds of active time of user with this id
     * @param int $userId
     * @param int $activeTime
     */
    public function updateUserActiveTime($userId, $activeTime) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.active_seconds = :active WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':active' => $activeTime,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    private function getSimpleUserResult($id) {
        parent::triggerIdNotFound($id, 'user');
        $query = 'SELECT user_id, user_roles_user_role_id, avatars_avatar_id, user_name , donated_amount FROM ' . Globals::getTableName('user') . ' WHERE user_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result;
    }

    /**
     * getLastComment
     * returns the last comment from this user
     * @param UserSimple $simpleUser
     * @return Comment
     */
    public function getLastComment(UserSimple $simpleUser) {
        return $this->_userDistDB->getLastComment($simpleUser);
    }

    public function addNotification($userId, Notification $notification) {
        $this->_notificationDB->addNotification($userId, $notification);
    }

    public function removeNotification($notificationId) {
        $this->_notificationDB->removeNotification($notificationId);
    }

    public function updateNotification($notificationId, $isRead) {
        $this->_notificationDB->updateNotification($notificationId, $isRead);
    }

    public function updateUserUserRole($userId, $userRoleId) {
        $this->_userDistDB->updateUserUserRole($userId, $userRoleId);
    }

    public function addAchievement($userId, $achievementId) {
        $this->_userDistDB->addAchievementToUser($userId, $achievementId);
    }

    public function updateUserAvatar($userId, $avatarId) {
        $this->_userDistDB->updateUserAvatar($userId, $avatarId);
    }

    private function createUserSimple($row, Avatar $avatar, UserRole $userRole) {
        return parent::getCreationHelper()->createUserSimple($row, $avatar, $userRole);
    }

    private function createUserDetailed(UserSimple $userSimple, $row, $recentNotifications, $lastComment, $achievements) {
        return parent::getCreationHelper()->createUserDetailed($userSimple, $row, $recentNotifications, $lastComment, $achievements);
    }

    private function getNotifications($userId, $limit) {
        return $this->_notificationDB->getNotifications($userId, $limit);
    }

    private function getAvatar($avatarId) {
        return $this->_userDistDB->getAvatar($avatarId);
    }

    private function getUserRole($userRoleId) {
        return $this->_userDistDB->getUserRole($userRoleId);
    }

    private function getAchievements($userId) {
        return $this->_userDistDB->getAchievements($userId);
    }

}
