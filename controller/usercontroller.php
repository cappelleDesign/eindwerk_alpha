<?php

class UserController {
    
    private $_sessionController;
    
    public function __construct($sessionController) {
        $this->init($sessionController);
    }
    
    private function init($sessionController) {
        $this->_sessionController = $sessionController;
    }
    
    public function processRequest($action) {
        switch ($action) {
            
        }
    }
}
