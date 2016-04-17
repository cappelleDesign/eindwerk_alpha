<?php

//require_once 'uservalidator.php';
//require_once 'beervalidator.php';
//require_once 'gpvalidator.php';

class FormValidationController {

    private $_userValidator;


    public function __construct() {
        $this->init();
    }

    private function init() {
        $this->_userValidator = new UserValidationController();
    }

    public function sanitizeInput($input) {
        if (isset($input)) {
            $input = stripslashes($input);
            $input = htmlentities($input);
            $input = strip_tags($input);
            return $input;
        } else {
            //FIXME handle error
        }
    }
    
    //user stuff
    public function validateLoginForm($loginArr, &$sysAdmin) {
        return $this->_userValidator->validateLoginForm($loginArr, $sysAdmin);
    }

    public function validatePwChangeForm($pwArr, &$sysAdmin) {
        return $this->_userValidator->validatePwChangeForm($pwArr, $sysAdmin);
    }

}
