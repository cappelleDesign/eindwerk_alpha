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
    
    /**
     * The long description for the image
     * @var string 
     */
    private $_desc;

    public function __construct($url, $alt, $desc) {        
        $this->setUrl($url);
        $this->setAlt($alt);
        $this->setDesc($desc);
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

    public function setDesc($desc) {
        $this->_desc = $desc;
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

    public function getDesc() {
        return $this->_desc;
    }

}
