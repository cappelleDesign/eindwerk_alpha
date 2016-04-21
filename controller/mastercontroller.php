<?php

class MasterController {

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
     * The controller in charge of user functionality
     * @var type 
     */
    private $_userController;

    /**
     * Used to validate input
     * @var FormValidationController
     */
    private $_validator;

    public function __construct() {
        $this->init();
    }

    private function init() {
        try {
            $configs = $this->getConfigs();
            $this->_service = new MasterService($configs);
            $this->_sessionController = new SessionController();
            $this->_userController = new UserController($this->_sessionController, $this->_service);
            $this->_validator = new formvalidationController();
        } catch (Exception $ex) {
            //TODO handle exception
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
        $configs = parse_ini_file(dirname(__FILE__) . '/../model/config.ini', true);
        return $configs[$section];
    }

    /**
     * getMenu
     * Returns the menu for this type to help build the menu
     * @param string $type
     * @return MenuItem[]
     */
    public function getMenu($type) {
        return $this->_service->getMenu($type);
    }

    private function getAction() {
        $pure = '';
        if (isset($_GET['action'])) {
            $pure = $_GET['action'];
        }
        $filtered = filter_var($pure, FILTER_SANITIZE_STRING);
        $entit = htmlentities($filtered, ENT_QUOTES);
        return $entit;
    }

    private function containsMenuItem($action, $type) {
        return $this->_service->containsMenuItem($action, $type);
    }

    public function processRequest() {
        $nextPage = 'home.php';
        $action = 'home';
        $isJson = false;        
        if (isset($_POST['isJson']) && !empty($_POST['isJson'])) {
            $isJson = $this->_validator->sanitizeInput(filter_input(INPUT_GET, 'isJson'));
        }
        if ($this->getAction()) {
            $action = $this->getAction();
        }
        if ($this->containsMenuItem($action, 'main')) {
            $nextPage = $this->processMainMenuRequest($action);
        }
        if ($this->containsMenuItem($action, 'profile')) {
            $this->processProfileMenuRequest($action);
        }
        if ($this->containsMenuItem($action, 'admin')) {
            $this->processAdminMenuRequest($action);
        }
        if (in_array($action, Globals::getUserActions())) {
            $nextPage = $this->processUserRequest($action, $isJson);
        }
        if (in_array($action, Globals::getHelperActions())) {
            $nextPage = $this->processHelperRequest($action, $isJson);
        }
        require_once $nextPage;
    }

    private function processMainMenuRequest($action) {
        switch ($action) {
            case 'home' :
                break;
            default :
                $action = 'home'; //FIXME TMP
        }
        $page = 'view/pages/' . $this->_service->containsMenuItem($action, 'main')->getPageName();
        return $page;
    }

    private function processProfileMenuRequest($action) {
//        echo '<script>console.log("profile request")</script>';
    }

    private function processAdminMenuRequest($action) {
//        echo '<script>console.log("menu request")</script>';
    }

    private function processUserRequest($action, $isJson) {
        return $this->_userController->processUserRequest($action, $isJson);
    }

    private function processHelperRequest($action, $isJson) {
        switch ($action) {
            case 'getCarouselSrcs':
                return $this->getSrcs();
            case 'getNewsfeedSrcs' :
                return;
            default :
                //TODO ERROR LOG 
                return;
        }
    }

    private function redirect($page) {
        
    }

    public function getCurrentUser() {
        if ($this->_sessionController->isLoggesdOn()) {
            return $this->_sessionController->getSessionAttr('current_user');
        }
        return FALSE;
    }

    public function getSrcs() {        
        $name = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'name'));
        $path = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'imagesPath'));
        $img = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'imageUrl'));
        $type = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'type'));
        $carouselSrcs = $this->_service->getImgSrcs($type, $name,$path, $img);
        $_POST['jsonData'] = $carouselSrcs;
        return 'data/json-data.php';
    }

}
