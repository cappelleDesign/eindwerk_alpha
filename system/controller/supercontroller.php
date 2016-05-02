<?php

abstract class SuperController {

    /**
     * The master service used to execute functions
     * @var MasterService
     */
    private $_service;

    /**
     * The controller in charge of session functionality
     * @var SessionController 
     */
    private $_sessionController;

    /**
     * The controller to navigate to error pages
     * @var ErrorController
     */
    private $_errorController;

    /**
     * Used to validate input
     * @var FormValidationController
     */
    private $_validator;

    public function __construct() {
        $this->superInit();
    }

    private function superInit() {
        $this->_validator = new formvalidationController();
        $this->_errorController = new ErrorController();
    }

    public function redirect($action) {
        header('Location: index.php?action=' . $action);
        exit();
    }

    public function getService() {
        return $this->_service;
    }

    public function getSessionController() {
        return $this->_sessionController;
    }

    public function getErrorController() {
        return $this->_errorController;
    }

    public function getValidator() {
        return $this->_validator;
    }

    public function getPagesRoot() {
        return Globals::getRoot('view', 'app') . '/pages/';
    }

    public function getJsonRoot() {
        return Globals::getRoot('view', 'app') . '/data/';
    }
    
    public function setService(MasterService $service) {
        $this->_service = $service;
    }

    public function setSessionController(SessionController $sessionController) {
        $this->_sessionController = $sessionController;
    }

    public function setErrorController(ErrorController $errorController) {
        $this->_errorController = $errorController;
    }

    public function setValidator(FormValidationController $validator) {
        $this->_validator = $validator;
    }


    
}
