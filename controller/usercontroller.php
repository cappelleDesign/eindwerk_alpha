<?php

class UserController {

    /**
     * The controller for session related functionality
     * @var SessionController
     */
    private $_sessionController;
    
    /**
     * The controller for validation purposes
     * @var FormValidationController 
     */
    private $_validator;
    
    /**
     * The master service to connect to the dao classes
     * @var MasterService
     */
    private $_service;
    
    public function __construct($sessionController, $service) {
        $this->init($sessionController, $service);
    }

    private function init($sessionController, $service) {
        $this->_sessionController = $sessionController;
        $this->_validator = new FormValidationController();    
        $this->_service = $service;
    }

    public function processUserRequest($action, $isJson) {
        switch ($action) {
            case 'login': 
                return $this->login($isJson);
            case 'loginPage':
                return 'login.php';
            default : 
                return 'testpages.php';
        }
    }

    private function getLoginArr() {
        if (isset($_POST['loginName']) && isset($_POST['loginPw'])) {
            $loginName = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'loginName'));
            $loginPw = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'loginPw'));
        }
        $loginArr = array(
            'loginName' => $loginName,
            'loginPw' => $loginPw
        );
        return $loginArr;
    }

    private function login($isJson) {
        $userArr = $this->getLoginArr();        
        $loginFormData = $this->_validator->validateLoginForm($userArr, $this->_service);
        $this->_sessionController->setSessionAttr('loginFormData', $loginFormData);
        if ($loginFormData['loginNameState']['errorClass'] === 'has-error' || $loginFormData['loginPwState']['errorClass'] === 'has-error') {
            return 'loginPage.php';
        }
        if (array_key_exists('extraMessage', $loginFormData)) {
            return 'loginPage.php';
        }
        try {
            $user = $this->_service;
        } catch (ServiceException $ex) {
            return $this->_errorController->goToErrorPage($ex);
        }
        parent::setSessionAttr('current_user', $user);
        header('Location: index.php?action=account');
        exit();
    }

}
