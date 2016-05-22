<?php

class UserController extends SuperController {

    public function __construct($sessionController, $service) {
        parent::__construct();
        $this->init($sessionController, $service);
    }

    private function init() {
        
    }

}
