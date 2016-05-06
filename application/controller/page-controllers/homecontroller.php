<?php

class HomeController extends SuperController {

    public function __construct() {
        parent::__construct();        
    }

    public function index() {
        $this->direct('home.php');
    }

}
