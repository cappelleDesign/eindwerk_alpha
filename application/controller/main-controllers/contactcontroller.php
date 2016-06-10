<?php

class ContactController extends SuperController{

    private $_subFolder;
    
    public function __construct() {
        parent::__construct('contact/');
    }
    
    public function index() {
        $this->internalDirect('contact.php');
    }

}
