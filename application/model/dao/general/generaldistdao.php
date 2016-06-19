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
     * updateImgUrl
     * Updates the url for an image
     * @param string $urlPrev
     * @param string $urlNew
     */
    public function updateImgUrl($urlPrev, $urlNew);
    
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
    
    /**
     * Adds an avatar to the database
     * @param Avatar $avatar
     * @return int $id
     */
    public function addAvatar(Avatar $avatar);
    
    /**
     * Returns an avatar with this url for image
     * @param string $url
     * @return Avatar
     */
    public function getAvatarByUrl($url);
    
    /**
     * Removes the avatar with this id from the database
     * @param int $avatarId
     */
    public function removeAvatar($avatarId);
}
