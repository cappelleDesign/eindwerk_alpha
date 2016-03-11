<?php
/**
 * DaoObject
 * This is an interface for all classes that are suitable for a database
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface DaoObject {
    public function getId();
    public function setId($id=-1);
}
