<?php

class DonateController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('donate/');
    }
    
    public function index() {
        $this->internalDirect('donate.php');
    }

}
