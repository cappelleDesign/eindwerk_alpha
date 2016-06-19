<?php

/**
 * GeneralDistSqlDB
 * This is a class that handles general dist SQL database functions
 * @package dao
 * @subpackage dao.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class GeneralDistSqlDB extends SqlSuper implements GeneralDistDao {

    public function __construct($connection) {
        parent::__construct($connection);
    }

    /**
     * Adds an image to the database
     * @param Image $image
     * @return int $imageId
     */
    public function addImage(Image $image) {
        $search = $this->searchImage($image->getUrl());
        if ($search !== -1) {
            return $search->getId();
        }
        $t = Globals::getTableName('image');
        $query = 'INSERT INTO ' . $t;
        $query .= ' (img_uri, alt)';
        $query .= ' Values(:uri, :alt)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':uri' => $image->getUrl(),
            ':alt' => $image->getAlt()
        );
        $statement->execute($queryArgs);
        $id = parent::getLastId();
        return $id;
    }

    /**
     * getImage
     * Returns an image from the SQL database and returns it as an Image object
     * @param int $imageId
     * @return Image
     */
    public function getImage($imageId) {
        $query = 'SELECT * FROM ' . Globals::getTableName('image') . ' WHERE image_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $imageId);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        $image = NULL;
        if ($result) {
            $row = $result[0];
            $image = new Image($row['img_uri'], $row['alt']);
            $image->setId($row['image_id']);
            return $image;
        }
        return -1;
    }

    public function updateImgUrl($urlPrev, $urlNew) {
        $img = $this->searchImage($urlPrev);
        $t = Globals::getTableName('image');
        $query = 'UPDATE ' . $t;
        $query .= ' SET img_uri = :new WHERE img_uri = :prev';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':new' =>$urlNew,
            ':prev' =>$urlPrev
        );
        $statement->execute($queryArgs);
    }
    
    /**
     * searchImage
     * Searches for an image and returns it if found,
     * -1 otherwise
     * @param string $imgUrl
     * @return Image or -1 if not found
     */
    public function searchImage($imgUrl) {
        $t = Globals::getTableName('image');
        $query = 'SELECT * FROM ' . $t;
        $query .= ' WHERE img_uri = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $imgUrl);
        $statement->execute();
        $row = parent::fetch($statement, FALSE);
        if ($row) {
            $image = new Image($row['img_uri'], $row['alt']);
            $image->setId($row['image_id']);
            return $image;
        }
        return -1;
    }

    /**
     * getImages
     * Returns all the images
     * @return array $images
     */
    public function getImages() {
        $query = 'SELECT * FROM ' . Globals::getTableName('image');
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        $images = array();
        foreach ($result as $row) {
            $image = new Image($row['img_uri'], $row['alt']);
            $image->setId($row['image_id']);
            $images[$image->getId()] = $image;
        }
        return $images;
    }

    /**
     * removeImage
     * Removes an image from the database
     * @param int $imageId
     */
    public function removeImage($imageId) {
        $t = Globals::getTableName('image');
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE image_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $imageId);
        $statement->execute();
    }

    /**
     * Adds an avatar to the database
     * @param Avatar $avatar
     * @return int $id
     */
    public function addAvatar(Avatar $avatar) {
        $imgId = $this->addImage($avatar->getImage());
        $found = $this->getAvatarByUrl($avatar->getImage()->getUrl());
        if ($found) {
            $this->updateAvatar($found->getId(), $imgId);            
            return $found->getId();
        }
        $t = Globals::getTableName('avatar');
        $query = 'INSERT INTO ' . $t;
        $query .= '(images_image_id, tier)';
        $query .= ' VALUES(:imgId, :tier)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':imgId' => $imgId,
            ':tier' => $avatar->getTier()
        );
        $statement->execute($queryArgs);                
        return parent::getLastId();
    }

    /**
     * Returns an avatar with this url for image
     * @param string $url
     * @return Avatar
     */
    public function getAvatarByUrl($url) {
        $avT = Globals::getTableName('avatar') . ' a';
        $imgT = Globals::getTableName('image') . ' i';
        $query = 'SELECT * FROM ' . $avT;
        $query .= ' LEFT JOIN ' . $imgT . ' ON a.images_image_id = i.image_id';
        $query .= ' WHERE i.img_uri = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $url);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        if ($result) {
            $image = new Image($result['img_uri'], $result ['alt']);
            $image->setId($result['image_id']);
            $avatar = parent::getCreationHelper()->createAvatar($result, $image);
            return $avatar;
        }
    }

    public function updateAvatar($avatarId, $imgId) {
        $avT = Globals::getTableName('avatar');
        $query = 'UPDATE ' . $avT;
        $query .= ' SET images_image_id = :imgId';
        $query .= ' WHERE avatar_id = :avId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':imgId' => $imgId,
            ':avId' => $avatarId
        );
        $statement->execute($queryArgs);
    }

    /**
     * Removes the avatar with this id from the database
     * @param int $avatarId
     */
    public function removeAvatar($avatarId) {
        //FIXME every user that had this avatar needs an other avatar
        parent::triggerIdNotFound($avatarId, 'avatar');
        $t = Globals::getTableName('avatar');
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE avatar_id = ?';
        $statmenet = parent::prepareStatement($query);
        $statmenet->bindParam(1, $avatarId);
        $statmenet->execute();
    }

}
