<?php

spl_autoload_register(function ($class_name) {
    $root = dirname(__FILE__);
    $dirs = array(
        '/../model/',
        '/../model/errorhandling/',
        '/../model/domain/general/',
        '/../model/domain/user/',
        '/../model/domain/review/',
        '/../model/dao/general/',
        '/../model/dao/user/'
    );
    $fileFound = false;
    foreach ($dirs as $dir) {
        if (file_exists($root . $dir . strtolower($class_name) . '.php')) {
            require_once($root . $dir . strtolower($class_name) . '.php');
            $fileFound = true;
            return;
        } else {
            $fileFound = false;
        }
    }
    if (!$fileFound) {
        //handle exception
    }
});

$user_db = new UserMySqlDB('127.0.0.1', 'reviews_admin', 'Admin001', 'souffe_reviews');
/*
 * to test:
 * add
 * remove
 * 
 */
echo 'Is email jens@localhost.be available? ';
echo $user_db->emailAvailable('jens@localhost.be') ? 'yes' : 'no';
echo '<br>';
echo 'Is username jens still available? ';
echo $user_db->usernameAvailable('jens') ? 'yes' : 'no';
echo '<br>';
echo 'Is there a user with id 1? ';
echo count($user_db->containsId(1)) ? 'yes' : 'no';
echo '<br>';
echo 'User with id 1 is: ';
var_dump($user_db->get(1));
