<?php

//FIXME SECURITY
class SessionController {

    public function __construct() {
        $this->init();
    }

    private function init() {
        new SecureSession();
        $sessionPath = sys_get_temp_dir();
        session_save_path($sessionPath);
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
                $this->updateUserActivity();
            }
        }
        session_write_close();
    }

    public function updateUserActivity() {
        $_SESSION['LAST_ACTIVITY'] = time();
        session_write_close();
    }

    public function isLoggedOn() {
        session_write_close();
        return isset($_SESSION['current_user']);
    }

    public function setSessionAttr($key, $val) {
        $this->startSession();
        $_SESSION[$key] = $val;
        session_write_close();
    }

    public function getSessionAttr($key) {
        session_write_close();
        $val = '';
        if (isset($_SESSION[$key])) {
            $val = $_SESSION[$key];
        }
        return $val;
    }

    public function deleteSessionAttr($key) {
//        $this->startSession();
        unset($_SESSION[$key]);
        session_write_close();
    }

    public function destroySession() {
//        $this->startSession();
        session_destroy();
        session_write_close();
    }

}
