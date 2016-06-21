<?php

class ContactController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('contact/');
    }

    public function index() {
        $this->internalDirect('contact.php');
    }

    public function sendMail() {
        $contactArr = $this->getContactArr();
        if (!is_array($contactArr)) {
            echo $contactArr;
            return;
        }
        $validation = $this->getValidator()->validateContactForm($contactArr);
        $feedback = FALSE;
        if (array_search('has-error', array_column($validation, 'errorClass')) !== FALSE || array_key_exists('extraMessage', $validation)) {
            $feedback = $validation;
        }
        if (!$feedback) {
            $send = $this->getMailController()->mailContact($contactArr['mail'], $contactArr['subj'], $contactArr['msg']);
            if (!$send) {
                $validation['extraMessage'] = 'Could not send the email.';
                $feedback = $validation;
            }
        }            
        if ($feedback) {
            echo $this->getJson($feedback);
            return;
        }
        echo 'success';
        
//        $_POST['contact-feedback'] = $feedback;
//        $this->internalDirect('contact.php');
    }

    private function getContactArr() {
        $subj = '';
        $mail = '';
        $msg = '';
        $isHuman = '';
        if (isset($_POST['contact-subject']) && isset($_POST['contact-mail']) && isset($_POST['contact-body'])) {
            $subj = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'contact-subject'));
            $mail = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'contact-mail'));
            $msg = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'contact-body'));
            $isHuman = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'input-filter'));
        } else {
            return 'Error getting post values';
        }
        $contactArr = array(
            'subj' => $subj,
            'mail' => $mail,
            'msg' => $msg,
            'isHuman' => $isHuman
        );
        return $contactArr;
    }

}
