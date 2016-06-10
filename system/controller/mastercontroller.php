<?php

class MasterController {

    const DEFAULT_CONTROLLER = 'Home';
    const DEFAULT_ACTION = 'index';
    const CONTROLLER_PATH = 'application/controller/main-controllers/';
    const CONTROLLER_FILE = 'index.php';

    private $_controller;
    private $_action;
    private $_params;
    private $_sessionController;
    
    public function __construct() {               
        $this->init();
    }

    private function init() {
        try {
            $this->parseUri();
        } catch (Exception $ex) {
            Globals::cleanDump('error: ' . $ex);
            die();
            //FIXME handle error
        }
    }

    private function parseUri() {        
        $scriptprefix = str_replace(self::CONTROLLER_FILE, '', $_SERVER['SCRIPT_NAME']);
        $uri = str_replace(self::CONTROLLER_FILE, '', $_SERVER['REQUEST_URI']);
        $path = substr($uri, strlen($scriptprefix));
        $path = preg_replace('/[^a-zA-Z0-9]\//', "", $path);
        $path = trim($path, '/');

        @list($controller, $action, $params) = explode("/", $path, 3);
        if (isset($controller)) {
            $this->setController($controller);
        }
        $this->setAction($action);
        $this->setParams(explode("/", $params));
    }

    private function setController($controller) {
        $controller = ($controller) ? $controller : self::DEFAULT_CONTROLLER;
        $controllerfile = self::CONTROLLER_PATH . strtolower($controller) . 'controller' . '.php';
        // check if controller file exists
        if (!file_exists($controllerfile)) {
            die("Controller '$controller' could not be found.");
        } else {
            require_once($controllerfile);
            $this->_controller = $controller . 'Controller';
        }
        return $this;
    }

    function setAction($action) {
        if ($action) {
            $actionClean = str_replace('-', '', $action);            
            $this->_action = $actionClean;
        } else {
            $this->_action = self::DEFAULT_ACTION;
        }
    }

    function setParams($params) {
        if (isset($params)) {
            $this->_params = $params;
        } else {
            $this->_params = [];
        }
    }

    public function processRequest() {
        $reflector = new ReflectionClass($this->_controller);
        $method = $reflector->getMethod($this->_action);
        $parameters = $method->getNumberOfRequiredParameters();
        if (($parameters) > count($this->_params)) {
            die("Action '$this->_action' in class '$this->_controller' expects $parameters mandatory
parameter(s), you only provided " . count($this->_params) . ".");
            //TODO handle error in proper way
        }
        $controller = new $this->_controller();
        call_user_func_array(array($controller, $this->_action), $this->_params);
    }

}
