<?php

class UserDistSqlDB extends SqlSuper implements UserDistDao {

    public function __construct($host, $username, $passwd, $database) {
        parent::__construct('mysql:host=' . $host, $username, $passwd, $database);
    }

    public function containsId($id, $instance) {
        $query = 'SELECT COUNT(*) FROM ' . Globals::getTableName($instance) . ' WHERE user_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result[0]['COUNT(*)'];
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
     * addAchievement
     * Adds an achievement to a user in the sql database
     * @param int $userId
     * @param int $achievementId
     * @throws DBException
     */
    public function addAchievement($userId, $achievementId) {
        parent::triggerIdNotFound($userId, 'user');
        parent::triggerIdNotFound($achievementId, 'achievement');
        $query = 'INSERT INTO ' . Globals::getTableName('achievements_users') . ' (user_id, achievements_id) VALUES (:userId, :achievementId);';
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
     * Gets an avatar from the sql database and returns it as an Avatar object
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

    //FIXME last edited 19/03 13:19 
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
}
