<?php

//FIXME SECURITY
// implement new version of secure session : https://github.com/ezimuel/PHP-Secure-Session
class SessionController {

    public function __construct() {
        $this->init();
    }

    private function init() {
//        new SecureSession();
//        $sessionPath = sys_get_temp_dir();
//        session_save_path($sessionPath);
    }

    public function startSession() {     
        if (session_status() == PHP_SESSION_NONE) {
            session_name('neoludus_service');
            session_set_cookie_params(0);
            session_start();
        }
    }

    public function checkUserActivity() {
        if ($this->isLoggedOn()) {
            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
                // request 30 minates ago
                $this->deleteSessionAttr('current_user');
            } else {
                $active = $this->updateUserActivity();
                return $active;
            }
        } else {
            return -1;
        }
    }

    public function updateUserActivity() {
        $prevActive = time() - $_SESSION['LAST_ACTIVITY'];
        $_SESSION['LAST_ACTIVITY'] = time();
        return $prevActive;
    }

    public function isLoggedOn() {
        return isset($_SESSION['current_user']);
    }

    public function setSessionAttr($key, $val) {       
        $_SESSION[$key] = $val;        
    }

    public function getSessionAttr($key) {        
        $val = '';
        if (isset($_SESSION[$key])) {
            $val = $_SESSION[$key];
        }
        return $val;
    }

    public function deleteSessionAttr($key) {
//        $this->startSession();
        unset($_SESSION[$key]);       
    }

    public function destroySession() {
//        $this->startSession();
        session_destroy();        
    }

}
