<?php

class UserController extends SuperController {

    public function __construct($sessionController, $service) {
        parent::__construct();
        $this->init($sessionController, $service);
    }

    private function init($sessionController, $service) {
        $this->setSessionController($sessionController);
        $this->setService($service);
    }

    public function processUserRequest($action, $isJson) {
        $page = '';
        switch ($action) {
            case 'login':
                $page = $this->login($isJson);
                break;
            case 'loginPage':
                $page = 'login.php';
                break;
            case 'logout' :
                $page = $this->logOut($isJson);
                break;
            case 'getUser' :
                $page = $this->getUser($isJson);
                break;
            default :
                //TODO HANDLE PAGE NOT FOUND
                break;
        }
        return $page;
    }

    private function getLoginArr() {
        if (isset($_POST['loginName']) && isset($_POST['loginPw'])) {
            $loginName = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'loginName'));
            $loginPw = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'loginPw'));
            $isHuman = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'input-filter'));
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
        $loginFormData = $this->getValidator()->validateLoginForm($userArr, $this->getService());
        $this->getSessionController()->setSessionAttr('loginFormData', $loginFormData);
        if ($loginFormData['loginNameState']['errorClass'] === 'has-error' || $loginFormData['loginPwState']['errorClass'] === 'has-error') {
            $_POST['loginReturn'] = 'return';
            return 'login.php';
        }
        if (array_key_exists('extraMessage', $loginFormData)) {
            $_POST['loginReturn'] = 'return';
            return 'login.php';
        }
        try {
            $user = $this->getService()->getByIdentifier($userArr['loginName'], 'user');
        } catch (ServiceException $ex) {
//            return $this->_errorController->goToErrorPage($ex);
            //FIXME handle error!            
        }
        $this->getSessionController()->setSessionAttr('current_user', $user);
        $this->getSessionController()->updateUserActivity();
        $this->redirect('account');
    }

    private function logout($isJson) {
        $this->getSessionController()->deleteSessionAttr('current_user');
        $this->redirect('home');
    }

    public function getCurrentUser($isJson) {
        $user = false;
        if ($this->getSessionController()->isLoggedOn()) {
            $user = $this->getSessionController()->getSessionAttr('current_user');
        }
        if(!$isJson) {
            return $user;
        } else {
            
        }
    }

}
