<?php

abstract class SuperController extends NavigationController{

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
        $configs = $this->getConfigs();
        $this->_service = new MasterService($configs);
        $this->_sessionController = new SessionController();
        $this->_validator = new formvalidationController();
        $this->_errorController = new ErrorController();
        $this->getSessionController()->startSession();
        $this->getSessionController()->checkUserActivity();
    }

    /**
     * getConfigs
     * Helper function to get correct database configuration
     * @return array
     */
    private function getConfigs() {
        $section = 'database_versio';
        if (strpos(dirname(__FILE__), 'xampp')) {
            $section = 'database_local';
        }
        $configs = parse_ini_file(dirname(__FILE__) . '/../model/config/config.ini', true);
        return $configs[$section];
    }

    /**
     * getMenu
     * Returns the menu for this type to help build the menu
     * @param string $type
     * @return MenuItem[]
     */
    public function getMenu($type) {
        return $this->getService()->getMenu($type);
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

    public function getCurrentUser($isJson) {
        $user = false;
        if ($this->getSessionController()->isLoggedOn()) {
            $user = $this->getSessionController()->getSessionAttr('current_user');
        }
        if (!$isJson) {
            return $user;
        } else {
            
        }
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
