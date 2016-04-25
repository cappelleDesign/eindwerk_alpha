<?php

class UserController {

    /**
     * The controller for session related functionality
     * @var SessionController
     */
    private $_sessionController;
    
    private $_errorController;
    
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
                return 'view/pages/login.php';
            default : 
                return 'view/pages/testpages.php';
        }
    }

    private function getLoginArr() {
        if (isset($_POST['loginName']) && isset($_POST['loginPw'])) {
            $loginName = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'loginName'));
            $loginPw = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'loginPw'));
            $isHuman = $this->_validator->sanitizeInput(filter_input(INPUT_POST, 'input-filter'));
        }
        $loginArr = array(
            'loginName' => $loginName,
            'loginPw' => $loginPw,
            'isHuman' => $isHuman
        );
        return $loginArr;
    }

    private function login($isJson) {
        $userArr = $this->getLoginArr();        
        $loginFormData = $this->_validator->validateLoginForm($userArr, $this->_service);
        $this->_sessionController->setSessionAttr('loginFormData', $loginFormData);
        if ($loginFormData['loginNameState']['errorClass'] === 'has-error' || $loginFormData['loginPwState']['errorClass'] === 'has-error') {
            $_POST['loginReturn'] = 'return';
            return 'view/pages/login.php';
        }
        if (array_key_exists('extraMessage', $loginFormData)) {
            $_POST['loginReturn'] = 'return';
            return 'view/pages/login.php';
        }
        try {
//            $user = $this->_service->getByIdentifier($userArr['loginName'], 'user');            
        } catch (ServiceException $ex) {
//            return $this->_errorController->goToErrorPage($ex);
            //FIXME handle error!            
        }               
//        $this->_sessionController->setSessionAttr('current_user', '$user');
//        header('Location: index.php?action=account');
//        exit();
    }

}
