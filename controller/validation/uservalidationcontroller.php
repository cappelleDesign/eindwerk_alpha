<?php

/**
 * UserValidationController
 * This class helps to validate forms related to user actions
 * @package controller
 * @subpackage validation
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserValidationController {

    private $_req = 'is required field.';

    public function __construct() {
        
    }

    /**
     * validateLoginForm
     * Validates the login form
     * @param array $loginArr
     * @param MasterService $sysAdmin
     * @return array
     */
    public function validateLoginForm($loginArr, $sysAdmin) {
        $result = $this->getValidationArrayLogin();
        if ($this->isHuman($loginArr['isHuman'], $result)) {
            $this->validateloginName($loginArr['loginName'], $result);
            $this->validateLoginPw($loginArr['loginPw'], $result);
            $this->validateLoginValid($loginArr['loginName'], $loginArr['loginPw'], $result, $sysAdmin);
        }
        return $result;
    }

    /**
     * validatePwChangeForm
     * Validates the update password form
     * @param array $pwArr
     * @param MasterService $sysAdmin
     * @return array
     */
    public function validatePwChangeForm($pwArr, &$sysAdmin) {
        $result = $this->getValidationArrayPw();
        $this->validatePwOld($pwArr['pwOld'], $pwArr['username'], $result, $sysAdmin);
        $this->validatePwNew($pwArr['pwNew'], $result);
        $this->validatePwNewRepeat($pwArr['pwNew'], $pwArr['pwNewRepeat'], $result);
        return $result;
    }

    /**
     * getValidationArrayPw
     * To get the validation array for password forms
     * @return array
     */
    private function getValidationArrayPw() {
        $validationArray = array(
            'pwOldState' => array(
                'errorClass' => '',
                'errorMessage' => '',
                'prevVal' => ''
            ), 'pwNewState' => array(
                'errorClass' => '',
                'errorMessage' => '',
                'prevVal' => ''
            ), 'pwNewRepeatState' => array(
                'errorClass' => '',
                'errorMessage' => '',
                'prevVal' => ''
            )
        );
        return $validationArray;
    }

    private function isHuman($inputFilter, &$result) {
        if (!empty(trim($inputFilter))) {
            $result['extraMessage'] = 'It seems like you filled in the are you a robot field..';
            return false;
        }
        return true;
    }

    /**
     * validatePwOld
     * Validates the old password field
     * @param string $pwOld
     * @param string $loginName
     * @param array $result
     * @param MasterService $sysAdmin
     */
    private function validatePwOld($pwOld, $loginName, &$result, $sysAdmin) {
        $result['pwOldState']['errorClass'] = 'has-success';
        $result['pwOldState']['errorMessage'] = '';
        if (!(trim($pwOld))) {
            $result['pwOldState']['errorClass'] = 'has-error';
            $result['pwOldState']['errorMessage'] = 'Old password ' . $this->_req;
        }
        try {
            $user = $sysAdmin->getByIdentifier($loginName, 'user');
            if ($user->authenticate($pwOld) < 1) {
                $result['pwOldState']['errorClass'] = 'has-error';
                $result['pwOldState']['errorMessage'] = 'Wrong password for this user';
            }
        } catch (ServiceException $ex) {
            $result['pwOldState']['errorClass'] = 'has-error';
            $result['pwOldState']['errorMessage'] = 'Wrong password for this user';
        }
    }

    /**
     * validatePwNewRepeat
     * validates the password repeat field
     * @param string $pwNew
     * @param string $pwNewrepeat
     * @param array $result
     */
    private function validatePwNewRepeat($pwNew, $pwNewrepeat, &$result) {
        $result['pwNewRepeatState']['errorMessage'] = '';
        if ($pwNew !== $pwNewrepeat) {
            $result['pwNewRepeatState']['errorClass'] = 'has-error';
            $result['pwNewRepeatState']['errorMessage'] = 'The repeated password did not match.';
        }
    }

    /**
     * validatePwNew
     * Validates the new password field
     * @param string $pwNew
     * @param array $result
     */
    private function validatePwNew($pwNew, &$result) {
        $result['pwNewState']['errorClass'] = 'has-success';
        $result['pwNewState']['errorMessage'] = '';
        $result['pwNewState']['prevVal'] = $pwNew;
        if (!(trim($pwNew))) {
            $result['pwNewState']['errorClass'] = 'has-error';
            $result['pwNewState']['errorMessage'] = 'Password ' . $this->_req;
        } else {
            $uppercase = preg_match('@[A-Z]@', $pwNew);
            $lowercase = preg_match('@[a-z]@', $pwNew);
            $number = preg_match('@[0-9]@', $pwNew);
            $special = preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $pwNew);
            if (!$uppercase) {
                $result['pwNewState']['errorClass'] = 'has-error';
                $result['pwNewState']['errorMessage'] = 'A password should contain at least one uppercase character.<br>';
            } else if (!$lowercase) {
                $result['pwNewState']['errorClass'] = 'has-error';
                $result['pwNewState']['errorMessage'] = 'A password should contain at least one lowercase character.<br>';
            } else if (!$number) {
                $result['pwNewState']['errorClass'] = 'has-error';
                $result['pwNewState']['errorMessage'] = 'A password should contain at least one number.<br>';
            } else if (!$special) {
                $result['pwNewState']['errorClass'] = 'has-error';
                $result['pwNewState']['errorMessage'] = 'A password should contain at least one special character.<br>';
            }
        }
    }

    /**
     * getValidationArrayLogin
     * Returns the validation array for login 
     * @return array
     */
    private function getValidationArrayLogin() {
        $validationArray = array(
            'loginNameState' => array(
                'errorClass' => '',
                'errorMessage' => '',
                'prevVal' => ''
            ), 'loginPwState' => array(
                'errorClass' => '',
                'errorMessage' => '',
                'prevVal' => ''
            )
        );
        return $validationArray;
    }

    /**
     * validateLoginName
     * Validates the login name (or email) field for login
     * @param string $loginName
     * @param array $result
     */
    private function validateLoginName($loginName, &$result) {
        $result['loginNameState']['errorClass'] = 'has-success';
        $result['loginNameState']['errorMessage'] = '';
        $result['loginNameState']['prevVal'] = $loginName;
        if (!(trim($loginName))) {
            $result['loginNameState']['errorClass'] = 'has-error';
            $result['loginNameState']['errorMessage'] = 'Username ' . $this->_req;
        }
    }

    /**
     * validateLoginPw
     * Validates the password field for login
     * @param string $loginPw
     * @param array $result
     */
    private function validateLoginPw($loginPw, &$result) {
        $result['loginPwState']['errorClass'] = 'has-success';
        $result['loginPwState']['errorMessage'] = '';
        $result['loginPwState']['prevVal'] = $loginPw;
        if (!(trim($loginPw))) {
            $result['loginPwState']['errorClass'] = 'has-error';
            $result['loginPwState']['errorMessage'] = 'Password ' . $this->_req;
        }
    }

    /**
     * validateLoginValid
     * Checks if the name field an pw field match to a user as username and pw
     * @param string $loginName
     * @param string $loginPw
     * @param array $result
     * @param MasterService $sysAdmin
     */
    private function validateLoginValid($loginName, $loginPw, &$result, $sysAdmin) {
        try {
            $user = $sysAdmin->getByIdentifier($loginName, 'user');
            Globals::cleanDump($user);
        } catch (ServiceException $ex) {
            $result['extraMessage'] = 'No user with this username/email and password found';
            $result['loginNameState']['errorClass'] = 'has-error';
            $result['loginPwState']['errorClass'] = 'has-error';
        }
    }

}
