<?php

require_once 'system/view/phpscripts/PHPMailer-master/PHPMailerAutoload.php';
define('APPLICATION_PATH', 'application/');
define('SYSTEM_PATH', 'system/');
ini_set('display_errors', E_ALL);
date_default_timezone_set('utc');
spl_autoload_register(function ($class_name) {
    $sys = SYSTEM_PATH;
    $app = APPLICATION_PATH;
    $dirs = array(
        'model/',
        'model/errorhandling/',
        'model/domain/',
        'model/domain/general/',
        'model/domain/user/',
        'model/domain/review/',
        'model/dao/',
        'model/dao/general/',
        'model/dao/general/comment/',
        'model/dao/general/vote/',
        'model/dao/general/newsfeed/',
        'model/dao/user/',
        'model/dao/user/dist/',
        'model/dao/user/notification/',
        'model/dao/review/',
        'model/dao/review/dist/',
        'model/dao/review/game/',
        'model/dao/review/game/dist/',
        'model/service/',
        'model/service/creation/',
        'controller/',
        'controller/settings/',
        'controller/validation/',
        'controller/model-controllers/',
        'controller/page-controllers/',
        'controller/session/'
    );
    $fileFound = false;
    foreach ($dirs as $dir) {
        if (file_exists($app . $dir . strtolower($class_name) . '.php')) {
            require_once($app . $dir . strtolower($class_name) . '.php');
            $fileFound = true;
            return;
        } else if (file_exists($sys . $dir . strtolower($class_name) . '.php')) {
            require_once($sys . $dir . strtolower($class_name) . '.php');
            $fileFound = true;
            return;
        } else {
            $fileFound = false;
        }
    }
    if (!$fileFound) {
//        require_once '/model/errorhandling/errorlogger.php';
//        ErrorLogger::logError(new ControllerException('could not initiate website', NULL));
    }
});

try {
    $controller = new MasterController();
    $controller->processRequest();
} catch (Exception $ex) {
    Globals::cleanDump($ex);
}

function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val) - 1]);
    switch ($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

function max_file_upload_in_bytes() {
    //select maximum upload size
    $max_upload = return_bytes(ini_get('upload_max_filesize'));
    //select post limit
    $max_post = return_bytes(ini_get('post_max_size'));
    //select memory limit
    $memory_limit = return_bytes(ini_get('memory_limit'));
    // return the smallest of them, this defines the real limit
    return min($max_upload, $max_post, $memory_limit);
}

?>
