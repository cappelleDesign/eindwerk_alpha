<?php

/**
 * DaoFactory
 * This is a class that functions as a factory class to get database subclasses
 * @package dao
 * @subpackage dao
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class DaoFactory {

    private $_connection;

    public function __construct() {
        
    }

    /**
     * getSupportedTypes
     * Returns all the supported database types
     * @return string
     */
    public function getSupportedTypes() {
        $supported = array('memdb', 'mysql');
        return $supported;
    }

    /**
     * getUserDB
     * Returns a user database with the type depending on the configs
     * @param array $configs
     * @return UserDao
     * @throws DBException
     */
    public function getUserDB($configs) {
        $this->checkConfigs('users', $configs);
        $dbType = $configs['type.users'];
        $userDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $userDB = new UserSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for users: ' . $dbType, NULL);
        }
        return $userDB;
    }

    /**
     * checkConfigs
     * Checks if the configs contain all the needed informations for the given type.
     * If no exception is thrown, all needed info was present
     * @param string $type
     * @param array $configs
     * @throws DBException
     */
    private function checkConfigs($type, $configs) {
        if (!isset($configs) || !is_array($configs) || empty($configs)) {
            throw new DBException('No valid configuration found', NULL);
        }
        if (!array_key_exists('type.' . $type, $configs)) {
            throw new DBException('No config found for ' . $type . ' database type', NULL);
        }        
    }

    private function createMysqlConnection($host, $username, $passwd, $database) {
        if (!$this->_connection) {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $database;
            $this->_connection = new PDO($dsn, $username, $passwd);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }
    }

}
