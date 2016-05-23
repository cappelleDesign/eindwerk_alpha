<?php

try {
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $userDb = new UserSqlDB($connection);
    $commentDb = new CommentSqlDB($connection, $userDb);
    $reviewDb = new ReviewSqlDB($connection);
    $notifHandler = new notificationHandler($userDb, $commentDb, $reviewDb);
    $service = new CommentService($commentDb, $userDb, $notifHandler);
    $comment = $commentDb->get(1);

    $posterJens = $userDb->get(1);
    $posterJens2 = $userDb->get(2);

//    addIt($service, $posterJens); 
    $service->removeComment(3, 1);
    
//    Globals::cleanDump($service->getComment(1));
    
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}

function addIt($service, $posterJens) {
$comment0 = new Comment(1,1, $posterJens, NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
$service->addComment($comment0);

$comment0 = new Comment(3,1, $posterJens, NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
$service->addComment($comment0);

$comment0 = new Comment(4,1, $posterJens, NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
$service->addComment($comment0);

$comment0 = new Comment(5,1, $posterJens, NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
$service->addComment($comment0);    
}
