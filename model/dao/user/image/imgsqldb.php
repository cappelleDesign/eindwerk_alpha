<?php

class ImgSqlDB extends SqlSuper implements ImgDao {

    public function __construct($host, $username, $passwd, $database) {
        parent::__construct($host, $username, $passwd, $database);
    }

    public function add(DaoObject $daoObject) {
        
    }

    public function containsId($id) {
        
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

    /**
     * updateUserAvatar
     * updates the user's avatar
     * @param int $userId
     * @param id $avatarId
     * @return Avatar returns the new avatar
     */
    public function updateUserAvatar($userId, $avatarId) {
        $this->triggerIdNotFound($userId);
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
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array();
        $statement->execute($queryArgs);
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

    protected function createAvatar($row, Image $image) {
        $avatar = new Avatar($image, $row['tier']);
        $avatar->setId($row['avatar_id']);
        return $avatar;
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

}
