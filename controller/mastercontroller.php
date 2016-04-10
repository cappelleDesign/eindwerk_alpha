<?php

class MasterController {

    private $_service;

    public function __construct() {
        $this->init();
    }

    private function init() {
        try {
            $configs = parse_ini_file(dirname(__FILE__) . '/../model/config.ini');
            $this->_service = new MasterService($configs);
        } catch (Exception $ex) {
            //TODO handle exception
        }
    }

}
