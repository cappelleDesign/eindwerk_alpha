<?php
//ini_set('display_errors', '0');
spl_autoload_register(function ($class_name) {
    $root = dirname(__FILE__);
    $dirs = array(
        '/model/',
        '/model/errorhandling/',
        '/model/domain/general/',
        '/model/domain/user/',
        '/model/domain/review/',
        '/model/dao/general/',
        '/model/dao/user/',
        '/model/dao/user/dist/',
        '/model/dao/user/notification/',
        '/model/service/',
        '/controller/'
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
        require_once '/model/errorhandling/errorlogger.php';
        ErrorLogger::logError(new ControllerException('could not initiate website', NULL));
    }
});
try {
    $controller = new MasterController();
    $controller->processRequest();
} catch (Exception $ex) {

}

//require_once('view/pages/home.php');
//require_once 'testing/serviceTesting.php';
