<?php

class MasterService {

    private $_daoFactory;
    private $_userService;
    private $_mainMenu;
    private $_adminMenu;
    private $_profileMenu;

    //TODO other services

    public function __construct($configs) {
        $this->init($configs);
    }

    private function init($configs) {
        $this->_daoFactory = new DaoFactory();
        $userDB = $this->_daoFactory->getUserDB($configs);
        $this->_userService = new UserService($userDB);
        //TODO add other services init
        $this->createMainMenu();
        $this->createAdminMenu();
        $this->createProfileMenu();
    }

    private function createMainMenu() {
        
    }

    private function createAdminMenu() {
        
    }

    private function createProfileMenu() {
        
    }

    public function getMenu($type) {
        switch ($type) {
            case 'main':
                return $this->_mainMenu;
            case 'admin':
                return $this->_adminMenu;
            case 'profile':
                return $this->_profileMenu;
            default :
                throw new ServiceException('Could not get a menu list for \'' + $type + '\'', NULL);
        }
    }

    public function containsMenuItem($menuItem, $type) {
        switch ($type) {
            case 'main':
                return array_key_exists($menuItem, $this->_mainMenu);
            case 'admin':
                return array_key_exists($menuItem, $this->_adminMenu);
            case 'profile':
                return array_key_exists($menuItem, $this->_profileMenu);
            default :
                return false;
        }
    }

    public function getUserService() {
        return $this->_userService;
    }

    public function add(DaoObject $daoObj, $type) {
        switch ($type) {
            case 'user':
                $this->getUserService()->addUser($daoObj);
                return $daoObj;
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

    public function remove($daoId, $type) {
        switch ($type) {
            case 'user':
                $this->getUserService()->removeUser($daoId);
                return true;
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

    public function get($daoId, $type) {
        switch ($type) {
            case 'user':
                return $this->getUserService()->getUser($daoId);
            case 'userSimple' :
                return $this->getUserService()->getSimpleUser($daoId);
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

    public function getByIdentifier($identifier, $type) {
        switch ($type) {
            case 'user':
                return $this->getUserService()->getUserByUserName($identifier);
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

    public function addToUser(UserDetailed $user, DaoObject $daoObj, $type) {
        switch ($type) {
            case 'notification':
                $this->_userService->addNotification($user, $daoObj);
                return $user;
            case 'achievement' :
                $this->_userService->addAchievement($user, $daoObj);
                return $user;
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

    public function updateUser(UserDetailed $user, $type, $param1 = '', $param2 = '') {
        switch ($type) {
            case 'pw':
                $this->getUserService()->updatePw($user, $param1, $param2);
                return $user;
            case 'userRole':
                $this->getUserService()->updateUserUserRole($user, $param1);
                return $user;
            case 'avatar':
                $this->getUserService()->updateUserAvatar($user, $param1);
                return $user;
            case 'donated':
                $this->getUserService()->updateUserDonated($user, $param1);
                return $user;
            case 'karma':
                $this->getUserService()->updateUserKarma($user, $param1);
                return $user;
            case 'regKey':
                $this->getUserService()->updateUserRegKey($user, $param1);
                return $user;
            case 'warning':
                $this->getUserService()->updateUserWarnings($user);
                return $user;
            case 'diamond':
                $this->getUserService()->updateUserDiamonds($user, $param1, $param2);
                return $user;
            case 'dateTimePref':
                $this->getUserService()->updateUserDateTimePref($user, $param1);
                return $user;
            case 'lastLogin':
                $this->getUserService()->updateUserLastLogin($user, $param1, $param2);
                return $user;
            case 'activeTime':
                $this->getUserService()->updateUserActiveTime($user, $param1);
                return $user;
            case 'notification':
                $this->getUserService()->updateNotification($user, $param1, $param2);
                return $user;
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

    public function removeFromUser(UserDetailed $user, $id, $type) {
        switch ($type) {
            case 'notification':
                $this->getUserService()->removeNotification($user, $id);
            default :
                throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
        }
    }

}
