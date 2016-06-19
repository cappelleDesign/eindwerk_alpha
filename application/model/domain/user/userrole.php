<?php

/**
 * UserRole
 * @package model
 * @subpackage domain.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserRole implements DaoObject {

    /**
     * Id of the user role in database
     * @var int 
     */
    private $_id = -1;

    /**
     * Display name of the user role
     * @var string 
     */
    private $_name;

    /**
     * Flag to determine the rights for users with this role
     * @var int 
     */
    private $_accessFlag;

    /**
     * Minimum karma points required for this role
     * @var int
     */
    private $_karama_min;

    /**
     * Minimum number of diamonds required for this role
     * @var int
     */
    private $_diamond_min;

    public function __construct($name, $accessFlag, $karama_min, $diamond_min) {
        $this->setName($name);
        $this->setAccessFlag($accessFlag);
        $this->setKarama_min($karama_min);
        $this->setDiamond_min($diamond_min);
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function setAccessFlag($accessFlag) {
        $this->_accessFlag = $accessFlag;
    }

    public function setKarama_min($karama_min) {
        $this->_karama_min = $karama_min;
    }

    public function setDiamond_min($diamond_min) {
        $this->_diamond_min = $diamond_min;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function getAccessFlag() {
        return $this->_accessFlag;
    }

    public function getKarama_min() {
        return $this->_karama_min;
    }

    public function getDiamond_min() {
        return $this->_diamond_min;
    }

    /**
     * jsonSerialize
     * Returns object as Json array
     * @return array
     */
    public function jsonSerialize() {
        $jsonObj = array();
        $jsonObj['user_role_id'] = $this->getId();
        $jsonObj['user_role_name'] = $this->getName(); 
        $jsonObj['user_role_access_flag'] = $this->getAccessFlag();
        $jsonObj['user_role_karma_min'] = $this->getKarama_min(); 
        $jsonObj['user_role_diamond_min'] = $this->getDiamond_min(); 
        return $jsonObj;
    }

}
