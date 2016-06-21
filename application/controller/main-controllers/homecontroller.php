<?php

class HomeController extends SuperController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {        
        $jsonS = file_get_contents($this->getBase() . '/reviews/get');        
        $_POST['reviews'] = $jsonS;
        $this->direct('home.php');
    }

}
