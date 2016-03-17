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

    protected function prepareStatement($query) {
        $statement = $this->_connection->prepare($query);
        return $statement;
    }

    protected function getConnection() {
        return $this->_connection;
    }

    protected function getLastId() {
        return $this->_connection->lastInsertId();
    }


    protected function executeInternalQuery($query) {
        try {
            $this->_connection->query($query);
        } catch (Exception $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    protected function executeExternalQuery($query, $queryArgs) {
        $statement = $this->prepareStatement($query);
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result;
    }

}
