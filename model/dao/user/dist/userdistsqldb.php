<?php
/**
 * UserDistSqlDB
 * This is a class that handels user dist SQL database functions
 * @package dao
 * @subpackage dao.user.dist
 */
class UserDistSqlDB extends SqlSuper implements UserDistDao {

    /**
     * An instance of the general dist database to help create some objects
     * @var GeneralDistDao 
     */
    private $_generalDistDao;
    
    public function __construct($host, $username, $passwd, $database, $generalDistDao) {
        parent::__construct('mysql:host=' . $host, $username, $passwd, $database);
        $this->init($generalDistDao);
    }
    
    private function init($generalDistDao){
        $this->_generalDistDao = $generalDistDao;
    }

    /**
     * updateUserAvatar
     * updates the user's avatar
     * @param int $userId
     * @param id $avatarId
     * @return Avatar returns the new avatar
     */
    public function updateUserAvatar($userId, $avatarId) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.avatars_avatar_id = :avatarId WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':avatarId' => $avatarId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
        return $this->getAvatar($avatarId);
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
        parent::triggerIdNotFound($userId, 'user');
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

    /**
     * addAchievementToUser
     * Adds an achievement to a user in the SQL database
     * @param int $userId
     * @param int $achievementId
     * @throws DBException
     */
    public function addAchievementToUser($userId, $achievementId) {
        parent::triggerIdNotFound($userId, 'user');
        parent::triggerIdNotFound($achievementId, 'achievement');
        $query = 'INSERT INTO ' . Globals::getTableName('achievement_user') . ' (user_id, achievements_id) VALUES (:userId, :achievementId);';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':userId' => $userId,
            ':achievementId' => $achievementId
        );
        try {
            $statement->execute($queryArgs);
        } catch (Exception $ex) {
            throw new DBException($ex->getMessage(), NULL);
        }
    }

    /**
     * getAvatar
     * Gets an avatar from the SQL database and returns it as an Avatar object
     * @param int $avatarId
     * @return Avatar
     */
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

    /**
     * getImage
     * Gets an image from the SQL database and returns it as an Image object
     * @param int $imageId
     * @return Image
     */
    protected function getImage($imageId) {
        return $this->_generalDistDao->getImage($imageId);            
    }

    /**
     * updateUserUserRole
     * Updates the user role of a user
     * @param int $userId
     * @param int $userRoleId
     * @return UserRole the new user role
     */
    public function updateUserUserRole($userId, $userRoleId) {
        parent::triggerIdNotFound($userId, 'user');
        $userT = Globals::getTableName('user');
        //FIXME should userRoleId existence be checked?
        $query = 'UPDATE ' . $userT . ' SET ' . $userT . '.user_roles_user_role_id = :userRoleId WHERE ' . $userT . '.user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':userRoleId' => $userRoleId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
        return $this->getUserRole($userRoleId);
    }

    /**
     * getUserRole
     * Gets a User Role from the SQL database
     * @param int $userRoleId
     * @return UserRole
     */
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
    private function getVoters($commentId) {
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

    /**
     * getLastComment
     * Gets the user's last Comment from the SQL database
     * @param UserSimple $simpleUser
     * @return type
     */
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

    /**
     * createAvatar
     * Uses the CreationHelper to create an Avatar object
     * @param array $row
     * @param Image $image
     * @return Avatar
     */
    private function createAvatar($row, Image $image) {
        return parent::getCreationHelper()->createAvatar($row, $image);
    }

    /**
     * createAchievement
     * Uses the CreationHelper to create an Achievement object
     * @param array $row
     * @param Image $image
     * @return Achievement
     */
    private function createAchievement($row, Image $image) {
        return parent::getCreationHelper()->createAchievement($row, $image);
    }

    /**
     * createUserRole
     * Uses the CreationHelper to create a UserRole object
     * @param array $row
     * @return UserRole
     */
    private function createUserRole($row) {
        return parent::getCreationHelper()->createUserRole($row);
    }

    /**
     * createLastComment   
     * Uses the CreationHelper to create a Comment object 
     * @param array $row
     * @param UserSimple $poster
     * @param array $voters
     * @return Comment
     */
    private function createLastComment($row, UserSimple $poster, $voters) {
        return parent::getCreationHelper()->createLastComment($row, $poster, $voters);
    }    
    
    /**
     * getAvatars
     * Returns all the avatars
     * @return array $avatars
     */
    public function getAvatars() {
        $avatarT = Globals::getTableName('avatar');
        $query = 'SELECT * FROM ' . $avatarT;
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $avatars = array();
        foreach ($result as $row) {
            $image = $this->getImage($row['images_image_id']);
            $avatar = $this->createAvatar($row, $image);
            $avatars[$avatar->getId()] = $avatar;
        }
        return $avatars;
    }

    /**
     * getUserRoles
     * REturns all the user roles
     * @return array $userRoles
     */
    public function getUserRoles() {
        $userRolesT = Globals::getTableName('userRole');
        $query = 'SELECT * FROM ' . $userRolesT;
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $userRoles = array();
        foreach ($result as $row) {            
            $userRole = $this->createUserRole($row);
            $userRoles[$userRole->getId()] = $userRole;
        }
        return $userRoles;
    }

    /**
     * getAllAchievements
     * Returns all the achievements
     * @return array $achievements
     */
    public function getAllAchievements() {
        $achievementT = Globals::getTableName('achievement');
        $query = 'SELECT * FROM ' . $achievementT;
        $statement = parent::prepareStatement($query);
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

}
