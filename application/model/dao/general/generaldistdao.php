<?php

/**
 * GeneralDistDao
 * This is an interface for all classes that handle general dist database functionality
 * @package dao
 * @subpackage dao.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface GeneralDistDao {

    /**
     * getImage
     * Returns the image with this id
     * @param int $imageId
     * @return Image $image
     */
    public function getImage($imageId);

    /**
     * getImages
     * Returns all the images in the database
     * @return array $images
     */
    public function getImages();
}
