<?php

/**
 * Avatar
 * An avater picture to be used for users
 * @package model
 * @subpackage domain.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Avatar implements DaoObject {

    /**
     * The id of the avatar
     * @var int
     */
    private $_id;

    /**
     * The image of the avatar
     * @var Image
     */
    private $_image;

    /**
     * The tier this avatar belongs to
     * @var int
     */
    private $_tier;

    public function __construct(Image $image, $tier) {
        $this->setImage($image);
        $this->setTier($tier);
    }

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setImage(Image $image) {
        $this->_image = $image;
    }

    public function setTier($tier) {
        $this->_tier = $tier;
    }

    public function getId() {
        return $this->_id;
    }

    public function getImage() {
        return $this->_image;
    }

    public function getTier() {
        return $this->_tier;
    }

    public function jsonSerialize() {
        $arr = array();
        //TODO implement
        return $arr;
    }

}
