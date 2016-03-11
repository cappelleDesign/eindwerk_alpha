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
     * Where the role is positioned in the list of roles
     * @var int
     */
    private $_followup;

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

    public function __construct($name, $accessFlag, $followup, $karama_min, $diamond_min) {
        $this->setName($name);
        $this->setAccessFlag($accessFlag);
        $this->setFollowup($followup);
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

    public function setFollowup($followup) {
        $this->_followup = $followup;
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

    public function getFollowup() {
        return $this->_followup;
    }

    public function getKarama_min() {
        return $this->_karama_min;
    }

    public function getDiamond_min() {
        return $this->_diamond_min;
    }

}
