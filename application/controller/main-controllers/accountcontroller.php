<?php

class AccountController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('account/');
    }

    public function index() {
        if ($this->getCurrentUser() && $this->getCurrentUser()->getUserRole()->getAccessFlag() >= 100) {
            $this->redirect('admin');
            return;
        }
        $_POST['is_login'] = 1;
        $this->internalDirect('account.php');
    }

    public function loginPage($isJson) {
        $_POST['is_login'] = 1;
        $_POST['avatars'] = file_get_contents($this->getBase() . 'user/avatar/all');
        if ($isJson && $isJson === 'true') {
//            Globals::cleanDump('json enabled');
            $this->internalDirect('account.php');
        } else {
            $this->internalDirect('account.php');
        }
    }

    public function registerPage() {
        $_POST['is_login'] = 0;
        $_POST['avatars'] = file_get_contents($this->getBase() . 'user/avatar/all');
        $this->internalDirect('account.php');
    }

    public function forgotPassForm($isJson) {
        Globals::cleanDump('password forget not implemented yet');
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
                if ($user->getUserRole()->getAccessFlag() === -999) {
                    $loginFormData['extraMessage'] = 'This account has not yet been validated, check your email for a registration mail from info@neoludus.com';
                    $loginFormData['extraMessage'] .= 'or <a href="account/registration-mail/' . $user->getEmail() . '/' . '">send</a> a new mail';
                }
                if ($user->getUserRole()->getAccessFlag() === -999) {
                    
                }
                if ($user->getUserRole()->getAccessFlag() === -999) {
                    
                }
                if ($hasError) {
                    $_POST['loginReturn'] = 'return';
                    $this->loginPage($isJson);
                    return;
                }
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
            setcookie('notifSucc', 'Welcome back!', 0, '/');
            if (isset($_COOKIE['last_page']) && $_COOKIE['last_page']) {
                $cookie = filter_input(INPUT_COOKIE, 'last_page');
                if (strpos($cookie, 'neoludus') || strpos($cookie, 'localhost')) {
                    header('Location:' . $cookie);
                    return;
                }
                $this->redirect($cookie);
            } else {
                $this->redirect('account');
            }
        }
    }

    public function logout($isJson) {
        $this->getSessionController()->deleteSessionAttr('current_user');
        setcookie('notifNfo', 'See you later!', 0, '/');
        $this->redirect('home');
    }

    public function register() {
        $rollFlag = -999;
        $mail = $_POST['user-mail'];
        $username = $_POST['user-name'];
        $pwd = $_POST['user-pwd'];
        $avatar = $_POST['avatar'];
        $regkey = Globals::randomString(60);
        //FIXME ADD SERVER VALIDATION!!!!!!!!!!!!!
        $url = $this->getBase() . 'user/add/' . $username . '/' . $mail . '/' . $pwd . '/' . $avatar . '/' . $rollFlag . '/' . $regkey;
        $add = file_get_contents($url);
        if ($add === 'success') {
            $add = $this->sendRegistrationMail($mail, $regkey) ? 'success' : 'error';
            $this->redirect('home');
            return;
        }
        if ($add !== 'success') {
            setcookie('notifErr', 'Something went wrong with the registration process :(', 0, '/');
            $this->registerPage();
        }
    }

    public function sendRegistrationMail($mail, $regkey) {
        $mailed = $this->getMailController()->mailRegistration($mail, $regkey);
        if ($mailed) {
            setcookie('notifNfo', 'A mail has been send to ' . $mail . '. Follow the instruction to complete your registration', 0, '/');
            return true;
        } else {
//            $userId = $this->getService()->getByIdentifier($mail, 'user');
//            $this->getService()->remove($userId->getId(), 'user');
            return false;
        }
    }

    public function registerConfirm($mail, $regkey) {
        $user = $this->getService()->getByIdentifier($mail, 'user');
        $error = false;
        if (!$user) {
            setcookie('notifErr', 'No user found for this email address :(', 0, '/');
            $error = true;
        } else if ($user->getUserRole()->getAccessFlag() !== -999) {
            setcookie('notifErr', 'This user is already fully registered', 0, '/');
            $error = true;
        } else if ($user->getRegKey() !== $regkey) {
            //FIXME send new mail
            setcookie('notifErr', 'This regkey did not match', 0, '/');
            $error = true;
        } else {
            $userRole = $this->getService()->getByIdentifier('1', 'userRole');
            $regkey = Globals::randomString(60);
            $this->getService()->updateUser($user, 'userRole', $userRole);
            $this->getService()->updateUser($user, 'regKey', $regkey);
        }
        if (!$error) {
            $this->getSessionController()->setSessionAttr('current_user', $user);
            $this->getSessionController()->updateUserActivity();
            setcookie('notifSucc', 'Welcome to neoludus brother!', 0, '/');
        }
        $this->redirect('home');
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
