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

    /**
     * The creation helper (factory)
     * @var UserCreationHelper
     */
    private $_creationHelper;

    /**
     * The PDO connection
     * @var PDO 
     */
    private $_connection;

    public function __construct($host, $username, $passwd, $database) {
        //have to make sure database exists on sql server or find way to set db on the fly
        $dsn = $host . ';dbname=' . $database;
        try {
            $this->_connection = new PDO($dsn, $username, $passwd);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_creationHelper = new UserCreationHelper();
        } catch (PDOException $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    /**
     * tableExists
     * Checks if a table already exists
     * @param string $tableName
     * @return boolean
     */
    protected function tableExists($tableName) {
        try {
            $query = 'SELECT 1 FROM farao.' . $tableName . ' LIMIT 1';

            $result = $this->_connection->query($query);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    /**
     * getConnection
     * returns the connections
     * @return PDO
     */
    protected function getConnection() {
        return $this->_connection;
    }

    /**
     * getCreationHelper
     * returns the creationHelper 
     * @return UserCreationHelper
     */
    protected function getCreationHelper() {
        return $this->_creationHelper;
    }

    /**
     * triggerIdNotFound
     * Checks if the Id is in the db of the instance and throws an exception if it isn't
     * @param int $id
     * @param string $instance
     * @throws DBException
     */
    protected function triggerIdNotFound($id, $instance) {
        if (!$this->containsId($id, $instance)) {
            throw new DBException(strtoupper($instance) . ' with id ' . $id . ' not found.', NULL);
        }
    }

    /**
     * containsId
     * Checks if a daoObject with a specific id exists in the database
     * @param int $id
     * @param string $instance 
     * @return string, a row of the database containing the daoObject or false
     */
    public function containsId($id, $instance) {
        $idCol = Globals::getIdColumnName($instance);
        $query = 'SELECT COUNT(*) FROM ' . Globals::getTableName($instance) . ' WHERE ' . $idCol . '=?';
        $statement = $this->prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result[0]['COUNT(*)'];
    }

    /**
     * prepareStatement
     * Uses PDO to create a PDOStatement
     * @param string $query
     * @return PDOStatement
     */
    protected function prepareStatement($query) {
        $statement = $this->_connection->prepare($query);
        return $statement;
    }

    /**
     * getLastId
     * Uses PDO to get the id of the last insert
     * @return int
     */
    protected function getLastId() {
        return $this->_connection->lastInsertId();
    }

    /**
     * executeInternalQuery
     * Used for quick queries that are not called from a website action
     * @param string $query
     * @throws DBException
     */
    protected function executeInternalQuery($query) {
        try {
            $this->_connection->query($query);
        } catch (Exception $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    /**
     * executeExternalQuery
     * Used for full queries caused by a call from the site
     * @param string $query
     * @param array $queryArgs
     * @return array
     */
    protected function executeExternalQuery($query, $queryArgs) {
        $statement = $this->prepareStatement($query);
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result;
    }

}
