<?php

class AccountController extends SuperController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->direct('account.php');
    }

    public function loginPage($isJson) {
        if ($isJson && $isJson === 'true') {
            Globals::cleanDump('json enabled');
        } else {
            $this->direct('account.php');
        }
    }

    public function registerPage($isJson) {
        Globals::cleanDump('registerPage not implemented yet');
        die();
    }

    public function forgotPassForm($isJson) {
        Globals::cleanDump('registerPage not implemented yet');
        die();
    }

    public function login($isJson) {
        $userArr = $this->getLoginArr();
        $loginFormData = $this->getValidator()->validateLoginForm($userArr, $this->getService());
        $this->getSessionController()->setSessionAttr('loginFormData', $loginFormData);
        $hasError = false;
        if ($loginFormData['loginNameState']['errorClass'] === 'has-error' || $loginFormData['loginPwState']['errorClass'] === 'has-error') {
            $hasError = true;
        }
        if (array_key_exists('extraMessage', $loginFormData)) {
            $hasError = true;
        }
        if ($hasError) {
            $_POST['loginReturn'] = 'return';
            $this->loginPage($isJson);
        } else {
            try {
                $user = $this->getService()->getByIdentifier($userArr['loginName'], 'user');
                $format = Globals::getDateTimeFormat('mysql', true);
                $this->getService()->updateUser($user, 'lastLogin', DateFormatter::getNow()->format($format), $format);
            } catch (ServiceException $ex) {
                Globals::cleanDump($ex);
                die();
//            return $this->_errorController->goToErrorPage($ex);
                //FIXME handle error!            
            }
            $this->getSessionController()->setSessionAttr('current_user', $user);
            $this->getSessionController()->updateUserActivity();
            $this->redirect('account');
        }
    }

    public function logout($isJson) {
        $this->getSessionController()->deleteSessionAttr('current_user');
        $this->redirect('home');
    }

    public function register($isJson) {
        Globals::cleanDump('register not implemented yet');
        die();
        //TODO implement
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

}
