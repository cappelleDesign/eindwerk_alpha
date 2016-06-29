<?php

/**
 * UserController
 * This is the user controller for user related rest calls
 * @package service
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserController extends SuperController {

    public function get($identifier) {
        $user = -1;
        if (is_numeric($identifier)) {
            $user = $this->getUserById($identifier);
        } else if ($identifier === 'all') {
            $user = $this->getService()->getAll('user');
            echo $this->getJson($user);
            return;
        } else {
            $user = $this->getUserByStringId($identifier);
        }
        if ($user instanceof UserDetailed) {
            echo $this->getJson(array($user));
        } else {
            echo 'User not found';
        }
    }

    public function add($username, $mail, $pwd, $avatarId, $userRoleFlag, $regKey = -1) {
        $format = Globals::getDateTimeFormat('be', TRUE);
        $nowWithTime = DateFormatter::getNow()->format($format);
        $donated = 0;
        $karma = 0;
        $warnings = 0;
        $diamonds = 0;
        $dateTimePref = 'd/m/Y H:i:s';
        $created = $nowWithTime;
        $lastLogin = $nowWithTime;
        $activeTime = 0;
        $pwEnc = password_hash($pwd, PASSWORD_BCRYPT);
        if ($regKey === -1) {
            $regKey = Globals::randomString(64);
        }
        try {
            $avatar = $this->getService()->get($avatarId, 'avatar');
            $userRole = $this->getService()->getByIdentifier($userRoleFlag, 'userRole');
            $user = new UserDetailed($userRole, $avatar, $username, $donated, $pwEnc, $mail, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime);
            $user = $this->getService()->add($user, 'user');
            echo 'success';
        } catch (Exception $ex) {
            echo 'error';
        }
    }

    public function delete($userId) {
        
    }

    public function update() {
        
    }

    public function checkUsername($userName) {
        if ($this->getService()->checkAvailability($userName, 'username')) {
            echo 'valid';
        } else {
            echo 'invalid';
        }
    }

    public function checkEmail($email) {
        if ($this->getService()->checkAvailability($email, 'email')) {
            echo 'valid';
        } else {
            echo 'invalid';
        }
    }

    public function userRole($id) {
        $userRoles = 'No user roles found';
        if (is_numeric($id)) {
            $userRoles = array($this->getService()->getByIdentifier($id, 'userRole'));
        }
        if ($id === 'all') {
            $userRoles = $this->getService()->getAll('userRole');
        }
        echo $this->getJson($userRoles);
    }

    public function avatar($id = 'all') {
        $avatars = -1;
        if (is_numeric($id)) {
            $avatars = array($this->getService()->get($id, 'avatar'));
            ;
        } else if ($id === 'all') {
            $avatars = $this->getService()->getAll('avatar');
        }
        if ($avatars !== -1) {
            echo $this->getJson($avatars);
        } else {
            echo '-1';
        }
    }

    private function getUserById($id) {
        try {
            $user = $this->getService()->get($id, 'user');
            return $user;
        } catch (Exception $ex) {
            return -1;
        }
    }

    private function getUserByStringId($stringId) {
        try {
            $user = $this->getService()->getByIdentifier($stringId, 'user');
            return $user;
        } catch (Exception $ex) {
            return -1;
        }
    }

}
