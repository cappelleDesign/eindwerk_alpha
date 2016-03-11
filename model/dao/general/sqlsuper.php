<?php
/**
 * SqlSuper
 * This a is class that is a super class for all sql subclasses.
 * It has functions that are sql related and can/will be used by sql classes
 * @package dao
 * @subpackage dao.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class SqlSuper {

    private $_connection;

    public function __construct($host, $username, $passwd, $database) {
        //have to make sure database exists on sql server or find way to set db on the fly
        $dsn = $host . ';dbname=' . $database;
        try {
            $this->_connection = new PDO($dsn, $username, $passwd);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    protected function tableExists($tableName) {
        try {
            $query = 'SELECT 1 FROM farao.' . $tableName . ' LIMIT 1';

            $result = $this->_connection->query($query);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    protected function executeInternalQuery($query) {
        try {
            $this->_connection->query($query);
        } catch (Exception $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    protected function prepareStatement($query) {
        $statement = $this->_connection->prepare($query);
        return $statement;
    }

    protected function getConnection() {
        return $this->_connection;
    }

    protected function getSqlDateFormat() {
        return 'Y-m-d';
    }
    
    //    private function phpToMysqlFormatDate($str){
//        $date = date('Y-d-m H:i:s', strtotime(str_replace('-', '/', $str)));
//        return $date;
//    }
//    
//    private function mysqlToPhpFormatDate($str){
//        $date = date('d/m/Y H:i:s',strtotime($str));
//        return $date;
//    }
//    
}
