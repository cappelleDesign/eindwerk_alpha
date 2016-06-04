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
    public function getUserDB($configs, $voteDb, $genDistDb) {
        $this->checkConfigs('users', $configs);
        $dbType = $configs['type.users'];
        $userDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);                
                $userDB = new UserSqlDB($this->_connection, $voteDb, $genDistDb);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for users: ' . $dbType, NULL);
        }
        return $userDB;
    }
    
    /**
     * geGeneralDistDB
     * Returns a user database with the type depending on the configs
     * @param array $configs
     * @return UserDao
     * @throws DBException
     */
    public function getGeneralDistDB($configs) {
        $this->checkConfigs('generalDist', $configs);
        $dbType = $configs['type.generalDist'];
        $generalDist = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);                
                $generalDist = new GeneralDistSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for general dist: ' . $dbType, NULL);
        }
        return $generalDist;
    }

    /**
     * getVoteDB
     * Returns a Vote database with the type depending on the configs
     * @param array $configs
     * @return VoteSqlDB
     * @throws DBException
     */
    public function getVoteDB($configs) {
        $this->checkConfigs('votes', $configs);
        $dbType = $configs['type.votes'];
        $voteDb = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);                
                $voteDb = new VoteSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for votes: ' . $dbType, NULL);
        }
        return $voteDb;
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

    /**
     * createMysqlConnection
     * If the connection is not yet initialized, it will be set with these settings
     * @param string $host
     * @param string $username
     * @param string $passwd
     * @param string $database
     */
    private function createMysqlConnection($host, $username, $passwd, $database) {
        if (!$this->_connection) {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $database;
            $this->_connection = new PDO($dsn, $username, $passwd);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }
    }

}
