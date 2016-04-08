<?php

/**
 * Authenticator
 * This class checks passwords.
 * If the password is correct but has the wrong encryption type(older) than the encryption is updated to the new encryption type
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Authenticator {

    /**
     * authenticate
     * Checks if the password is correct using the latest encryption algo
     * @param string $pwString
     * @param string $pwEncrypted
     * @return int
     */
    public static function authenticate($pwString, $pwEncrypted) {
        if (password_verify($pwString, $pwEncrypted)) {
            return 1;
        }
        return -1;
    }

}
