<?php

class HomeController extends SuperController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {        
        $reviewsJson = file_get_contents($this->getBase() . '/reviews/get/all/3/created/desc/0');        
        $_POST['reviews'] = $reviewsJson;
        $newsfeedJson = file_get_contents($this->getBase() . '/newsfeeds/get/all/6');
        $_POST['newsfeed'] = $newsfeedJson;
        $this->direct('home.php');
    }

}
