<?php

class SuperValidator {

    protected function getRequiredFieldError() {
        return 'is required field.';
    }

    protected function isHuman($inputFilter, &$result) {
        if (!empty(trim($inputFilter))) {
            $result['extraMessage'] = 'It seems like you filled in the are you a robot field..';
            return false;
        }
        return true;
    }

    protected function getBasicArr() {
        $basic = array(
            'errorClass' => '',
            'errorMessage' => '',
            'prevVal' => ''
        );
        return $basic;
    }

    protected function initBasicArr($val, $name,&$result) {
        $result[$name]['errorClass'] = 'has-success';
        $result[$name]['errorMessage'] = '';
        $result[$name]['prevVal'] = $val;
    }
    
    protected function basicEmptyCheck($dispName ,$val, $name, &$result){
        $this->initBasicArr($val, $name, $result);
        if(!(trim($val))){
            $result[$name]['errorClass'] = 'has-error';
            $result[$name]['errorMessage'] = $dispName . ' ' . $this->getRequiredFieldError();
        }
    }
    
    protected function emailCheck($dispName, $val, $name, &$result) {
        $this->basicEmptyCheck($dispName, $val, $name, $result);
        if(!filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $result[$name]['errorClass'] = 'has-error';
            $result[$name]['errorMessage'] .= $val . ' is NOT a valid emailAddress';
        }
    }
}
