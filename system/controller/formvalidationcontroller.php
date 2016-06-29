<?php

//require_once 'uservalidator.php';
//require_once 'beervalidator.php';
//require_once 'gpvalidator.php';

class FormValidationController {

    /**
     * The user validator
     * @var UserValidationController
     */
    private $_userValidator;

    /**
     * The contact validator
     * @var ContactValidationController
     */
    private $_contactValidator;

    /**
     * The avatar validator
     * @var AvatarValidationController
     */
    private $_avatarValidator;

    public function __construct() {
        $this->init();
    }

    private function init() {
        $this->_userValidator = new UserValidationController();
        $this->_contactValidator = new ContactValidationController();
        $this->_avatarValidator = new AvatarValidationController();
    }

    public function sanitizeInput($input) {
        if (isset($input)) {
            $input = stripslashes($input);
            $input = htmlentities($input);
            $input = strip_tags($input);
            return $input;
        } else {
            return NULL;
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

    public function validateContactForm($contactArr) {
        return $this->_contactValidator->validateContactForm($contactArr);
    }

    public function validateAddAvatarForm($avatarArr) {
        return $this->_avatarValidator->validateAvatarAddForm($avatarArr);
    }
}
