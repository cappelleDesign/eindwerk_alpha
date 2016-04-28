<?php

class MasterController extends SuperController {

    /**
     * The controller in charge of user functionality
     * @var type 
     */
    private $_userController;

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    private function init() {
        try {
            $configs = $this->getConfigs();
            $this->setService(new MasterService($configs));
            $this->setSessionController(new SessionController());
            $this->_userController = new UserController($this->getSessionController(), $this->getService());
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
        return $this->getService()->getMenu($type);
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
        return $this->getService()->containsMenuItem($action, $type);
    }

    public function processRequest() {
        $pageRoot = $this->getPagesRoot();
        $nextPage = 'home.php';
        $action = 'home';
        $isJson = false;
        if (isset($_POST['isJson']) && !empty($_POST['isJson'])) {
            $isJson = $this->getValidator()->sanitizeInput(filter_input(INPUT_GET, 'isJson'));
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
        require_once $pageRoot . $nextPage;
    }

    private function processMainMenuRequest($action) {        
        switch ($action) {
            case 'home' :
                break;
            default :
                $action = 'home'; //FIXME TMP
        }
        $page = $this->getService()->containsMenuItem($action, 'main')->getPageName();
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

    public function getCurrentUser() {
        if ($this->getSessionController()->isLoggedOn()) {
            return $this->getSessionController()->getSessionAttr('current_user');
        }
        return FALSE;
    }

    public function getSrcs() {
//        $name = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'name'));
//        $path = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'imagesPath'));
//        $img = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'imageUrl'));
//        $type = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'type'));
//        $carouselSrcs = $this->_service->getImgSrcs($type, $name, $path, $img);
//        $_POST['jsonData'] = $carouselSrcs;
//        return 'data/json-data.php';
    }

    public function includeIncluder($fileName) {
        $root = Globals::getRoot('view', 'sys') . '/includes/';
        include $root . $fileName;
    }

    public function includeHeader() {
        $this->includeIncluder('header.php');
    }

    public function includeMenu($page) {
        $_GET['page'] = $page;
        $this->includeIncluder('menu.php');
    }

    public function includeFooter() {
        $this->includeIncluder('footer.php');
    }

    public function includeScripts() {
        $this->includeIncluder('scripts.php');
    }

}
