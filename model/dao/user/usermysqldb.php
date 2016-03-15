<?php

class UserMySqlDB extends UserSqlDB {
    public function __construct($host, $username, $passwd, $database) {
        parent::__construct('mysql:host=' . $host, $username, $passwd, $database);
        $this->init();
    }
    
    private function init() {
        $this->tableChecks();
    }
    
    private function tableChecks() {
        
    }
}
