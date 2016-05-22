<?php

/*
 * FOR TESTING PURPOSES ONLY 
 * 
 */

/**
 * Description of testcontroller
 *
 * @author jens
 */
class TestController extends SuperController{    
    
    public function index() {
        $_POST['data'] = 'testing';
        $this->direct('test.php');
    }
    
    public function commentDbTests() {
        require 'testing/commentTestingDB.php';
    }
    
    public function commentServiceTests() {
        require 'testing/commentTestingService.php';
    }
    
    public function dateTests() {
        require 'testing/timeTesting.php';
    }
}
