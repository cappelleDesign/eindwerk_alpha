<?php

/**
 * Dao
 * This is an interface that is a super class for classes that have crud abilities
 * @package dao
 * @subpackage dao
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */

interface Dao {

    /**
     * add
     * To add an object to the database
     * @param DaoObject $daoObject
     */
    public function add(DaoObject $daoObject);

    /**
     * remove
     * To remove an object from the database based on the id
     * @param int $id
     */
    public function remove($id);

    /**
     * get
     * To get an object from the database as a PHP object based on the id
     * @param int $id
     * @return DaoObject $daoObject
     */
    public function get($id);

    /**
     * getByString
     * To get objects from the database as a PHP object based on the name
     * if the name is not unique, it will return an array
     * @param string $identifier
     * @return array $daoObjects
     */
    public function getByString($identifier);
}
