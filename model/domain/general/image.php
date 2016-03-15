<?php

/**
 * Image
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Image implements DaoObject {

    /**
     * The id of the image in database
     * @var int
     */
    private $_id = -1;

    /**
     * The url of the image limited to the name.extension
     * @var string 
     */
    private $_url;

    /**
     * The alt text for the image
     * @var string 
     */
    private $_alt;

    public function __construct($url, $alt) {
        $this->setUrl($url);
        $this->setAlt($alt);
    }

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setUrl($url) {
        $this->_url = $url;
    }

    public function setAlt($alt) {
        $this->_alt = $alt;
    }

    public function getId() {
        return $this->_id;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function getAlt() {
        return $this->_alt;
    }

    public function jsonSerialize() {
        $arr = array();
        //TODO implement
        return $arr;
    }

}
