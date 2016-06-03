<?php

class GeneralDistSqlDB extends SqlSuper implements GeneralDistDao {

    public function __construct($connection) {
        parent::__construct($connection);
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
     * getImages
     * Returns all the images
     * @return array $images
     */
    public function getImages() {
        $query = 'SELECT * FROM ' . Globals::getTableName('image');
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $images = array();
        foreach ($result as $row) {
            $image = new Image($row['img_uri'], $row['alt']);
            $image->setId($row['image_id']);
            $images[$image->getId()] = $image;
        }
        return $images;
    }

}
