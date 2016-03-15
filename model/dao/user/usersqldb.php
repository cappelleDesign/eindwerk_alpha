<?php

/**
 * DaoObject
 * This is an abstract class for all classes that handle user SQL databases
 * @package dao
 * @subpackage dao.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
abstract class UserSqlDB extends SqlSuper implements UserDao {

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

    public function remove($id) {
        $this->triggerIdNotFound($id);
        $query = 'DELETE FROM ' . Globals::getTableName('user') . ' WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

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

    public function get($id) {
        $result = $this->containsId($id)['0'];
        if (!$result || empty($result)) {
            throw new DBException('could not find a user with this id. id was: ' . $id, NULL);
        }
        $user = $this->createUser($result, true);
        return $user;
    }

    public function getByString($identifier) {
        $userWithName = '';
        try {
            $query = 'SELECT `user_id`, `user_roles_user_role_id`, `avatars_avatar_id`, `user_name` , `donated_amount` FROM ' . Globals::getTableName('user') . ' WHERE user_name = ?';
            $statement = parent::prepareStatement($query);
            $statement->bindParam(1, $identifier);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $user = $this->createUser($row, false);
                $userWithName = $user;
            }
        } catch (PDOException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
        return $userWithName;
    }

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

    public function getSimple($id) {
        $result = $this->getSimpleUserResult($id)['0'];
        if (!$result || empty($result)) {
            throw new DBException('could not find a user with this id. id was: ' . $id, NULL);
        }
        $user = $this->createUser($result, false);
        return $user;
    }

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

    public function updateUserUserRole($userId, $userRoleId) {
        
    }

    public function updateUserAvatar($userId, $avatarId) {
        //TODO implement
    }

    public function updateUserDonated($userId, $donated) {
        //TODO implemment
    }

    public function updateUserMail($userId, $newEmail) {
        //TODO implement
    }

    public function updateUserKarma($userId, $newAmount) {
        //TODO implement
    }

    public function updateUserRegKey($userId, $regKey) {
        //TODO implement
    }

    public function updateUserWarnings($userId, $warnings) {
        //TODO implement
    }

    public function updateUserDiamonds($userId, $diamonds) {
        //TODO implement
    }

    public function updateUserDateTimePref($userId, $dateTimePref) {
        //TODO implement
    }

    public function updateUserLastLogin($userId, $lastLogin) {
        //TODO implement
    }

    public function updateUserActiveTime($userId, $activeTime) {
        //TODO implement
    }

    public function addNotification($userId, \Notification $notification) {
        //TODO implement
    }

    public function updateNotification($userId, $notificationId, $isRead) {
        //TODO implement
    }

    public function removeNotification($userId, $notificationId) {
        //TODO implement
    }

    //FIXME get unread notifications & get read notifications
    public function getNotifications($userId, $limit) {
        $this->triggerIdNotFound($userId);
        $query = 'SELECT * FROM ' . Globals::getTableName('notification') . '  WHERE user_id = ? AND notification_isread = 0 ORDER BY notifications.notification_date DESC';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $userId);
//        $statement->bindParam(2, $limit);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $notifications = array();
        foreach ($result as $row) {
            try {
                $notif = $this->createNotification($row);
                $notifications[$notif->getId()] = $notif;
            } catch (DomainModelException $ex) {
                throw new DBException($ex->getMessage(), $ex);
            }
        }
        return $notifications;
    }

    /**
     * getAchievements
     * Returns all the achievements of a user as an array
     * 
     * START ORIGINAL SQL SATEMENT
     * SELECT 
      achievements.image_id,
      achievements.achievement_id,
      achievements.name,
      achievements.desc,
      achievements.karma_award,
      achievements.diamond_award
      FROM
      achievements
      INNER JOIN achievements_users ON achievements.achievement_id = achievements_users.achievements_id
      WHERE achievements_users.user_id = 1
      -- GROUP BY achievements.achievement_id
     * END ORIGINAL SQL STATEMENT
     * 
     * @param int $userId
     * @return array
     * @throws DBException
     */
    public function getAchievements($userId) {
        $this->triggerIdNotFound($userId);
        $achTable = Globals::getTableName('achievement');
        $combiTable = Globals::getTableName('achievement_user');
        $query = 'SELECT ' . $achTable . '.image_id, ' . $achTable . '.achievement_id,  ' . $achTable . '.name,  ' . $achTable . '.desc,  ' . $achTable . '.karma_award,  ' . $achTable . '.diamond_award' .
                ' FROM  ' . $achTable . ' INNER JOIN  ' . $combiTable . ' ON ' . $achTable . '.achievement_id = ' . $combiTable . '.achievements_id' .
                ' WHERE  ' . $combiTable . '.user_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $userId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $achievements = array();
        foreach ($result as $row) {
            $image = $this->getImage($row['image_id']);
            $achievement = $this->createAchievement($row, $image);
            $achievements[$achievement->getId()] = $achievement;
        }
        return $achievements;
    }

    public function addAchievement($userId, $achievementId) {
        //TODO implement
    }

    public function getAvatar($avatarId) {
        $query = 'SELECT * FROM ' . Globals::getTableName('avatar') . ' WHERE avatar_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $avatarId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $row = $result[0];
        $image = $this->getImage($row['images_image_id']);
        $avatar = $this->createAvatar($row, $image);
        return $avatar;
    }

    public function getUserRole($userRoleId) {
        $query = 'SELECT * FROM ' . Globals::getTableName('userRole') . ' WHERE user_role_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $userRoleId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $row = $result[0];
        $userRole = $this->createUserRole($row);
        return $userRole;
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

    protected function createAvatar($row, Image $image) {
        $avatar = new Avatar($image, $row['tier']);
        $avatar->setId($row['avatar_id']);
        return $avatar;
    }

    protected function createUserRole($row) {
        $userRole = new UserRole($row['user_role_name'], $row['user_role_access_flag'], $row['user_role_karma_min'], $row['user_role_diamond_min']);
        $userRole->setId($row['user_role_id']);
        return $userRole;
    }

    protected function createNotification($row) {
        if (!$row) {
            throw new DBException('could not create notification', NULL);
        }
        $notif = new Notification($row['user_id'], $row['notification_txt'], $row['notification_date'], $row['notification_isread'], Globals::getDateTimeFormat('mysql', true));
        $notif->setId($row['notification_id']);
        return $notif;
    }

    protected function createAchievement($row, Image $image) {
        $achievement = new Achievement($image, $row['name'], $row['desc'], $row['karma_award'], $row['diamond_award']);
        $achievement->setId($row['achievement_id']);
        return $achievement;
    }

    protected function getImage($imageId) {
        $query = 'SELECT * FROM ' . Globals::getTableName('image') . ' WHERE image_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $imageId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $image = NULL;
        $row = $result[0];
        if ($row) {
            $image = new Image($row['img_uri'], $row['alt']);
            $image->setId($row['image_id']);
        }
        return $image;
    }

    protected function createLastComment($row, $poster, $voters) {
        //TODO implement correctly
        $comment = new Comment(1, $poster, 1, '$body', '21/10/1989 10:15:11', true, $voters, Globals::getDateTimeFormat('be', true));
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

}
