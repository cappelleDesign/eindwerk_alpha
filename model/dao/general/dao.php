<?php

/**
 * Dao
 * This is an interface that is a super class for classes that have crud abilities
 * @package dao
 * @subpackage dao.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */

interface Dao {

    public function add($daoObject);

    public function remove($id);

    public function containsId($id);

    public function get($id);

    public function getByString($identifier);
}
