<?php

class MasterService {

    private $_daoFactory;
    private $_userService;

    //TODO other services

    public function __construct($configs) {
        $this->init($configs);
    }

    private function init($configs) {
        $this->_daoFactory = new DaoFactory();
        $userDB = $this->_daoFactory->getUserDB($configs);
        $this->_userService = new UserService($userDB);
        //TODO add other services init
        $this->createMenu();
    }

    private function createMenu() {
        
    }

    public function getMenu() {
        return $this->_menu;
    }

    public function containsMenuItem($menuItem) {
        return array_key_exists($menuItem, $this->_menu);
    }

    public function getUserService() {
        return $this->_userService;
    }

    public function add(DaoObject $daoObj, $type) {
        switch ($type) {
            case 'user':
                $this->_userService->addUser($daoObj);
                return;
            default : 
                throw new ServiceException('Type \''.$type.'\' not recognized',NULL);
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
                throw new ServiceException('Type \''.$type.'\' not recognized',NULL);
        }
    }
}
