<?php

abstract class SuperController extends NavigationController {

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

    /**
     * Mail controller for mail functions
     * @var MailController
     */
    private $_mailController;

    /**
     * The image helper for image functions
     * @var imageHelper
     */
    private $_imgHelper;

    public function __construct($subFolder = '') {
        parent::__construct($subFolder);
        $this->superInit();
    }

    private function superInit() {
        $configs = $this->getConfigs();
        $this->_service = new MasterService($configs);
        $this->_sessionController = new SessionController();
        $this->_validator = new formvalidationController();
        $this->_errorController = new ErrorController();
        $this->_mailController = new MailController();
        $this->getSessionController()->startSession();
        $this->activityUpdate();        
        $this->_imgHelper = new imageHelper();
    }
    
    private function activityUpdate() {
        $active = $this->getSessionController()->checkUserActivity();
        if($active > 0){
            $user = $this->getCurrentUser();
            $this->getService()->updateUser($user, 'activeTime',$active);
        }
        
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

    public function getMailController() {
        return $this->_mailController;
    }

    public function getImgHelper() {
        return $this->_imgHelper;
    }

    /**
     * getCurrentUser
     * Returns the user from session if loged in
     * @param bool $isJson
     * @return UserDetailed
     */
    public function getCurrentUser($isJson = FALSE) {
        $user = false;
        if ($this->getSessionController()->isLoggedOn()) {
            $user = $this->getSessionController()->getSessionAttr('current_user');
        }
        if (!$isJson) {
            return $user;
        } else {

        }
    }

    public function getJson($obj) {
        if (!$obj) {
            echo 'Internal-error: No data recieved';
        } else {
            $data = $obj;
            if (!$data || !is_array($data)) {
                echo 'Internal-error: Data could not be created correctly';
            } else {
                $jsonStr = json_encode($data);
                if (!$jsonStr) {
                    echo 'Internal-error: The transaction from data to json had an error';
                } else {
                    echo $jsonStr;
                }
            }
        }
    }
    
    protected function prepUser($userRole, $avatar, $username, $pwEncrypted, $email){
        $format = Globals::getDateTimeFormat('be', TRUE);
        $nowWithTime = DateFormatter::getNow()->format($format);
        $donated = 0;
        $karma = 0;
        $regKey = Globals::randomString(60);
        $warnings = 0;
        $diamonds = 0;
        $dateTimePref = 'd/m/Y H:i:s';
        $created = $nowWithTime;
        $lastLogin = $nowWithTime;
        $activeTime = 0;
        $user = new UserDetailed($userRole, $avatar, $username, $donated, $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime);
        return $user;
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
