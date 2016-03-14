<?php

/**
 * MenuItem
 * This class is used to get the menu
 * @package service 
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class MenuItem {

    /**
     * The action to where the menuitem should bring you
     * @var string 
     */
    private $_action;
    
    /**
     * The display name of the menu item
     * @var string 
     */
    private $_description;
    
    /**
     * The page associated with this menu item.
     * Also used to check if the item should have active class
     * @var string
     */
    private $_pageName;

    public function __construct($action, $description, $pageName) {
        $this->setAction($action);
        $this->setDescription($description);
        $this->setPageName($pageName);
    }

    public function getAction() {
        return $this->_action;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getPageName() {
        return $this->_pageName;
    }

    private function setAction($action) {
        $this->_action = $action;
    }

    private function setDescription($description) {
        $this->_description = $description;
    }

    private function setPageName($pageName) {
        $this->_pageName = $pageName;
    }

}
