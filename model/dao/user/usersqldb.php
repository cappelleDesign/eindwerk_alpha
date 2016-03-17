<?php

/**
 * DaoObject
 * This is an abstract class for all classes that handle user SQL databases
 * @package dao
 * @subpackage dao.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
abstract class UserSqlDB extends SqlSuper implements UserDao {

    private $_userRoleDB;
    private $_notificationDB;
    private $_imgDB;
    
    public function __construct($host, $username, $passwd, $database) {
        parent::__construct($host, $username, $passwd, $database);
    }

    /**
     * add
     * Adds a user to 
     * @param UserDetailed $user
     * @throws DBException
     */
    public function add(UserDetailed $user) {
        if (!$user instanceof UserDetailed) {
            throw new DBException('The object you tried to add was not a user object', NULL);
        }
        if ($this->containsId($user->getId())) {
            throw new DBException('The database already contains a user with this id', NULL);
        }
        if (!$this->emailAvailable($user->getEmail())) {
            throw new DBException('This email is already in use. Make sure you did not already create an account');
        }
        if (!$this->usernameAvailable($user->getUsername())) {
            throw new DBException('Very sad to inform you that this username is already taken.');
        }
        $query = 'INSERT INTO `' . Globals::getTableName('user') . '` (`user_roles_user_role_id`, `avatars_avatar_id`, `user_name`, `user_hash_salt`, `user_email`, `user_karma`, `user_reg_key`, `user_warnings`, `user_diamonds`, `preference_datetime_format`, `user_created`, `last_login`, `donated_amomunt`, `active_seconds`)';
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
            ':created' => $user->getCreated(),
            ':last_login' => $user->getLastLogin(),
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
        $this->triggerIdNotFound($id);
        $query = 'DELETE FROM ' . Globals::getTableName('user') . ' WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

    /**
     * containsId
     * Checks if a user with a specific id exists on the website
     * @param int $id
     * @return string, a row of the database containing the user or false
     */
    public function containsId($id) {
        //FIXME this is not really what contains should do (too much data?)
        $query = 'SELECT * FROM ' . Globals::getTableName('user') . ' WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result;
    }

    /**
     * get
     * Returns the user with this id from the database as a user object
     * @param int $id
     * @return UserDetailed $user
     * @throws DBException if the no user with this id was found
     */
    public function get($id) {
        $result = $this->containsId($id)['0'];
        if (!$result || empty($result)) {
            throw new DBException('could not find a user with this id. id was: ' . $id, NULL);
        }
        $user = $this->createUser($result, true);
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
        $query = 'SELECT `user_id`, `user_roles_user_role_id`, `avatars_avatar_id`, `user_name` , `donated_amount` FROM ' . Globals::getTableName('user');
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $users = array();
        foreach ($result as $row) {
            $user = $this->createUser($row, false);
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
        $user = $this->createUser($result, false);
        return $user;
    }

    /**
     * updatePw
     * updates the password for a user with this id
     * @param int $userId
     * @param string $pwNew as new encrypted password
     */
    public function updatePw($userId, $pwNew) {
        $this->triggerIdNotFound($userId);
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET `user_hash_salt` = :pw WHERE `users`.`user_id` = :id';
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
        $this->triggerIdNotFound($userId);
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
        $this->triggerIdNotFound($userId);
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
        $this->triggerIdNotFound($userId);
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
        $this->triggerIdNotFound($userId);
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
        $this->triggerIdNotFound($userId);
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
        $this->triggerIdNotFound($userId);
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
        $this->triggerIdNotFound($userId);
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
     * @param type $userId
     * @param type $activeTime
     */
    public function updateUserActiveTime($userId, $activeTime) {
        $this->triggerIdNotFound($userId);
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.active_seconds = :active WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':active' => $activeTime,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }
   
    public function getLastComment(UserSimple $simpleUser) {
        $comT = Globals::getTableName('comment');
        $query = 'SELECT * FROM ' . $comT . ' WHERE ' . $comT . '.users_writer_id = ? ORDER BY comment_created DESC LIMIT 1';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $simpleUser->getId());
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        $voters = array();
        if ($row && isset($row['comment_id'])) {
            $voters = $this->getVoters($row['comment_id']);
        }
        return $this->createLastComment($row, $simpleUser, $voters);
    }

    protected function getSimpleUserResult($id) {
        $this->triggerIdNotFound($id);
        $query = 'SELECT `user_id`, `user_roles_user_role_id`, `avatars_avatar_id`, `user_name` , `donated_amount` FROM ' . Globals::getTableName('user') . ' WHERE user_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result;
    }

    protected function createUser($row, $detailed) {
        if (!$row) {
            throw new DBException('could not create user', NULL);
        }
        $id = $row['user_id'];
        $avatarId = $row['avatars_avatar_id'];
        $userRoleId = $row['user_roles_user_role_id'];
        $avatar = $this->getAvatar($avatarId);
        $userRole = $this->getUserRole($userRoleId);
        $simpleUser = new UserSimple($userRole, $avatar, $row['user_name'], $row['donated_amount']);
        $simpleUser->setId($id);
        if ($detailed) {
            return $this->createDetailedUser($simpleUser, $row['user_hash_salt'], $row['user_email'], $row['user_karma'], $row['user_reg_key'], $row['user_warnings'], $row['user_diamonds'], $row['preference_datetime_format'], $row['user_created'], $row['last_login'], $row['active_seconds']);
        }
        return $simpleUser;
    }

    protected function createDetailedUser(UserSimple $simpleUser, $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime) {
        $userId = $simpleUser->getId();
        $recentNotifications = $this->getNotifications($userId, 10);
        $achievements = $this->getAchievements($userId);
        $lastComment = $this->getLastComment($simpleUser);
        $detailedUser = new UserDetailed($simpleUser->getUserRole(), $simpleUser->getAvatar(), $simpleUser->getUsername(), $simpleUser->getDonated(), $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime, $lastComment, $recentNotifications, $achievements, Globals::getDateTimeFormat('mysql', true));
        $detailedUser->setId($userId);
        return $detailedUser;
    }

    protected function createLastComment($row, $poster, $voters) {
        $comment = new Comment($row['parent_id'], $poster, $row['review_id'], $row['comment_txt'], $row['comment_created'], $voters, Globals::getDateTimeFormat('be', true));
        $comment->setId($row['comment_id']);
        return $comment;
    }

    /**
     * getVoters
     * returns all votes for a comment
     * 
     * START ORIGINAL SQL STATEMENT
      SELECT
      users.user_id,
      users.user_name,
      comment_votes.vote_flag
      FROM
      `comment_votes` INNER JOIN
      users ON comment_votes.users_upvoter_id = users.user_id
      WHERE comment_votes.comment_id = 1
     * END ORIGINAL SQL STATEMENT
     * 
     * @param int $commentId
     */
    protected function getVoters($commentId) {
        $userT = Globals::getTableName('user');
        $combo = Globals::getTableName('comment_vote');
        $query = 'SELECT ' . $userT . '.user_id, ' . $userT . '.user_name,' . $combo . '.vote_flag' .
                ' FROM ' . $combo . ' INNER JOIN ' . $userT . ' ON ' . $combo . '.users_upvoter_id = ' . $userT . '.user_id' .
                ' WHERE ' . $combo . '.comment_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $commentId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $voters = array();
        foreach ($result as $row) {
            $voters[$row['user_id']] = array('userName' => $row['user_name'], 'voteFlag' => $row['vote_flag']);
        }
        return $voters;
    }

    protected function triggerIdNotFound($id) {
        if (!$this->containsId($id) || count($this->containsId($id)) < 1) {
            throw new DBException('User with id ' . $id . ' not found.', NULL);
        }
    }

    public function addNotification($userId, \Notification $notification) {
        
    }

    public function getNotifications($userId, $limit) {
        
    }

    public function removeNotification($notificationId) {
        
    }

    public function updateNotification($notificationId, $isRead) {
        
    }

    public function updateUserUserRole($userId, $userRoleId) {
        
    }

}
