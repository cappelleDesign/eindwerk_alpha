<?php

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

}
