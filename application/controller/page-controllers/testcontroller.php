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
        $_POST['data'] = 'Stront';
        $this->direct('test.php');
    }
}
