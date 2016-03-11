<?php

/**
 * DomainGlobals
 * This abstract class keeps all globals used in the domain package
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class DomainGlobals {

    //FIXME handle locale ?
    const BE_TIME_FORMAT = 'd/m/Y H:i:s';
    const MYSQL_TIME_FORMAT = 'Y/m/d H:i:s';
    const US_TIME_FORMAT = 'm/d/Y H:i:s';
    const COMMENT_DIAMOND_KARMA = 50;
    const REVIEW_DIAMOND_KARMA = 100;

    //FIXME move to other class
    static function randomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

}
