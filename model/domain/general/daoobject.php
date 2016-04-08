<?php
/**
 * DaoObject
 * This is an interface for all classes that are suitable for a database
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface DaoObject extends JsonSerializable {
    /**
     * getId
     * Returns the object's id
     * @return int $id
     */
    public function getId();
    /**
     * setId
     * Sets the id for this object
     * @param int $id
     */
    public function setId($id=-1);
}
