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
     * Adds an image to the database
     * @param Image $image
     * @return int $imageId
     */
    public function addImage(Image $image);

    /**
     * getImage
     * Returns the image with this id
     * @param int $imageId
     * @return Image $image
     */
    public function getImage($imageId);

    /**
     * searchImage
     * Searches for an image and returns it if found,
     * -1 otherwise
     * @param string $imgUrl
     * @return Image or -1 if not found
     */
    public function searchImage($imgUrl);

    /**
     * getImages
     * Returns all the images in the database
     * @return array $images
     */
    public function getImages();

    /**
     * Removes an image from the database
     * @param int $imageId
     */
    public function removeImage($imageId);
}
