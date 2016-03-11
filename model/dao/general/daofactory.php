<?php
/**
 * DaoFactory
 * This is a class that functions as a factory class to get database subclasses
 * @package dao
 * @subpackage dao.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class DaoFactory {

    public function __construct() {
        
    }

    public function getSupportedTypes() {
        $supported = array('memdb', 'mysql');
        return $supported;
    }

    public function getUserDB($configs) {
        $this->checkConfigs('users', $configs);
        $dbType = $configs['type.users'];
        $userDB = NULL;
        switch ($dbType) {
            case 'memdb':
                $userDB = new UserMemDB();
                break;
            case 'mysql' :
                $userDB = new UserMysqlDB($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for users: ' . $dbType, NULL);
        }
        return $userDB;
    }

    private function checkConfigs($type, $configs) {
        if (!isset($configs) || !is_array($configs) || empty($configs)) {
            throw new DBException('No valid configuration found', NULL);
        }
        if (!array_key_exists('type.' . $type, $configs)) {
            throw new DBException('No config found for ' . $type . ' database type', NULL);
        }
    }

}
