<?php

class ContactValidationController extends SuperValidator {

    public function validateContactForm($contactArr) {
        $result = $this->getValidationArray();
        if ($this->isHuman($contactArr['isHuman'], $result)) {
            $this->validateContactSubject($contactArr['subj'], $result);
            $this->validateContactMail($contactArr['mail'], $result);
            $this->validateContactMessage($contactArr['msg'], $result);
        }
        return $result;
    }

    private function validateContactSubject($val, &$result) {
        $this->basicEmptyCheck('Subject', $val, 'contactQTypeState', $result);
    }

    private function validateContactMail($val, &$result) {       
        $this->emailCheck('Email', $val, 'contactMailState', $result);
    }
    
    private function validateContactMessage($val, &$result) {
        $this->basicEmptyCheck('Message', $val, 'contactBodyState', $result);
    }

    private function getValidationArray() {
        $validationArray = array(
            'contactQTypeState' => $this->getBasicArr(),
            'contactMailState' => $this->getBasicArr(),
            'contactBodyState' => $this->getBasicArr()
        );
        return $validationArray;
    }

}
