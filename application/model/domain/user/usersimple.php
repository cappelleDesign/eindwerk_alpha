<?php

/**
 * UserSimple
 * A simple user with minimal information about the user
 * @package model
 * @subpackage domain.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserSimple implements DaoObject {

    /**
     * The user id
     * @var int
     */
    protected $_id = -1;

    /**
     * Userrole object with access info's
     * @var UserRole 
     */
    protected $_userRole;

    /**
     * The user's current avatar
     * @var Avatar 
     */
    protected $_avatar;

    /**
     * The name the user chose as display name
     * @var string 
     */
    protected $_username;

    /**
     * The amount the user already donated
     * @var int
     */
    protected $_donated;

    public function __construct(UserRole $userRole, Avatar $avatar, $username, $donated) {
        $this->init();
        $this->setUserRole($userRole);
        $this->setAvatar($avatar);
        $this->setUsername($username);
        $this->setDonated($donated);
    }

    /* ---------------------------------------------------------------------- */

    private function init() {
        
    }

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setUserRole(UserRole $userRole) {
        $this->_userRole = $userRole;
    }

    public function setAvatar(Avatar $avatar) {
        $this->_avatar = $avatar;
    }

    public function setUsername($username) {
        $this->_username = $username;
    }

    public function setDonated($donated) {
        $this->_donated = $donated;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getUserRole() {
        return $this->_userRole;
    }

    public function getAvatar() {
        return $this->_avatar;
    }

    public function getUsername() {
        return $this->_username;
    }

    public function getDonated() {
        return $this->_donated;
    }

    /**
     * jsonSerialize
     * Returns object as Json array
     * @return array
     */
    public function jsonSerialize() {
        $jsonObj = array();
        $jsonObj['user_id'] = $this->getId();
        $jsonObj['user_role'] = $this->getUserRole();
        $jsonObj['user_avatar'] = $this->getAvatar();
        $jsonObj['user_name'] = $this->getUsername();
        $jsonObj['user_donated'] = $this->getDonated();
        return $jsonObj;
    }

}
