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
        '/../model/dao/user/',
        '/../model/dao/user/dist/',
        '/../model/dao/user/notification/',
        '/../model/service/'
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

$configs = parse_ini_file(dirname(__FILE__) . '/../model/config.ini');
//print_r($configs);
try {
    $masterService = new MasterService($configs);

//    date_default_timezone_set('UTC');
//    $userDistDB = new UserDistSqlDB('127.0.0.1', 'neoludus_admin', 'Admin001', 'neoludus');
//    $newUserRole = $userDistDB->getUserRole(1);
//    $newAvatar = $userDistDB->getAvatar(1);
//    $newPw = password_hash('Admin001', PASSWORD_BCRYPT);
//    $newRegKey = Globals::randomString(32);
//    $now = date('d/m/Y H:i:s');
//    $newUser = new UserDetailed($newUserRole, $newAvatar, 'FreshMeat', 0, $newPw, 'newMail@mail.com', 0, $newRegKey, 0, 0, globals::getDateTimeFormat('be', true), $now, $now, 0, NULL, NULL, NULL, Globals::getDateTimeFormat('be', true));
//    $masterService->add($newUser, 'user');


    $user_db = new UserSqlDB('127.0.0.1', 'neoludus_admin', 'Admin001', 'neoludus');

    $user = $user_db->get(1);
    $name = $user->getUsername();
//    session_start();
//    $_SESSION['user'] = $user;
//    print_r($_SESSION['user']->getRecentNotifications());
//    $notif = new Notification(1, 'user service testing', '25/03/2016 13:00:00', false, Globals::getDateTimeFormat('be', true));
//    $masterService->addToUser($user, $notif, 'notification');
//    echo '<br>';
//    print_r($_SESSION['user']->getRecentNotifications());
    
    echo '<h1>Adding user to db with service</h1>';
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}