<?php


$configs = parse_ini_file(dirname(__FILE__) . '/../model/config.ini');
//print_r($configs);
try {
    $masterService = new MasterService($configs);

    date_default_timezone_set('UTC');

//    $newUserRole = $masterService->getByIdentifier(1, 'userRole');
//    $newAvatar = $masterService->get(1, 'avatar');
//    $newPw = password_hash('Admin001', PASSWORD_BCRYPT);
//    $newRegKey = Globals::randomString(32);
    $now = date('d/m/Y H:i:s');
//    $newUser = new UserDetailed($newUserRole, $newAvatar, 'FreshMeat', 0, $newPw, 'newMail@mail.com', 0, $newRegKey, 0, 0, globals::getDateTimeFormat('be', true), $now, $now, 0, NULL, NULL, NULL, Globals::getDateTimeFormat('be', true));
//    echo $masterService->add($newUser, 'user') ? 'v' : 'x';
//    $masterService->remove(3, 'user');
//    Globals::cleanDump($masterService->get(1, 'user'));
//    Globals::cleanDump($masterService->getByIdentifier('jens@localhost.be', 'user')); 
//    echo 'jens@localhost.be is ' . ($masterService->checkAvailability('jens@localhost.be', 'email') ? ' available' :' not available') . '<br>'; //should be not available
//    echo 'jens@localhostt.be is ' . ($masterService->checkAvailability('jens@localhostt.be', 'email') ? ' available' :' not available') . '<br>'; //should be available
//    echo 'jens is ' . ($masterService->checkAvailability('jens', 'username') ? ' available' :' not available') . '<br>'; //should be not available
//    echo 'snej is ' . ($masterService->checkAvailability('snej', 'username') ? ' available' :' not available') . '<br>'; //should be available
//    Globals::cleanDump($masterService->get(1, 'userSimple'));
//        Globals::cleanDump($masterService->getAll('users'));
//    Globals::cleanDump($masterService->getAll('avatars'));
//    Globals::cleanDump($masterService->getAll('userRoles'));
//    Globals::cleanDump($masterService->getAll('achievements'));
    $user = $masterService->get(4, 'user');
//    $masterService->updateUser($user, 'pw', 'Admin001', 'Test123');
//    $masterService->updateUser($user, 'userRole', $masterService->getByIdentifier(2, 'userRole'));
//    $masterService->updateUser($user, 'avatar', $masterService->get(2, 'avatar'));
//    $masterService->updateUser($user, 'donated', 500);
//    $masterService->updateUser($user, 'karma', 500);
//    $masterService->updateUser($user, 'regKey', Globals::randomString(32));
//    $masterService->updateUser($user, 'warning');
//    $masterService->updateUser($user, 'diamond', 1, 10);
//    $masterService->updateUser($user, 'dateTimePref', Globals::getDateTimeFormat('mysql', TRUE));    
//    $masterService->updateUser($user, 'lastLogin', $now, Globals::getDateTimeFormat('be', TRUE));
//    $masterService->updateUser($user, 'activeTime', 31556926);
//    $notif = new Notification(4, 'service testing purposes', $now, FALSE , Globals::getDateTimeFormat('be', true));
//    $masterService->addToUser($user, $notif, 'notification');
//    $masterService->updateUser($user, 'notification', 3, TRUE);
//    $masterService->removeFromUser($user, 3, 'notification');
//    $achievement = $masterService->getByIdentifier('achievement first', 'achievement');
//    $masterService->addToUser($user, $achievement, 'achievement');
    echo '<h1>ALL USER SERVICE TEST SUCCESSFULL</h1>';
} catch (Exception $ex) {
    echo $ex->getMessage() . '<br>' . $ex->getTraceAsString();
}