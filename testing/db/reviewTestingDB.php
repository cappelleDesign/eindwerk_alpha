<?php
try {
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $voteDb = new VoteSqlDB($connection);
    $userDb = new UserSqlDB($connection, $voteDb);
    $commentDb = new CommentSqlDB($connection, $userDb, $voteDb);
    $reviewDistDb = new ReviewDistSqlDB($connection, $generalDistDao);
    $reviewDb = new ReviewSqlDB($connection, NULL, NULL,NULL);
    $notifHandler = new notificationHandler($userDb, $commentDb, $reviewDb);
    $service = new CommentService($commentDb, $userDb, $notifHandler);
    $comment = $commentDb->get(1);

    $posterJens = $userDb->get(1);
    $posterJens2 = $userDb->get(2);
    $posterJens3 = $userDb->get(3);
    $posterJens4 = $userDb->get(4);
    $posterJens5 = $userDb->get(5);
    $posterJens6 = $userDb->get(6);       
    
    $posters = [$posterJens,$posterJens2,$posterJens3,$posterJens4,$posterJens5,$posterJens6];
//    $service->updateCommentText(1, 'updated text');
//    addIt($service, $posters);
//    Globals::cleanDump($service->getSubComments(1));
//    $service->removeComment(9, 1);

    Globals::cleanDump($service->getComment(1));
//   $service->addVoter($comment->getId(), $posterJens->getId(), $posterJens->getUsername(), 3);
//   $service->addVoter($comment->getId(), $posterJens2->getId(), $posterJens2->getUsername(), 2);
//   $service->addVoter($comment->getId(), $posterJens3->getId(), $posterJens3->getUsername(), 3);
//   $service->addVoter($comment->getId(), $posterJens4->getId(), $posterJens4->getUsername(), 3);
//   $service->addVoter($comment->getId(), $posterJens5->getId(), $posterJens5->getUsername(), 2);
//   $service->addVoter($comment->getId(), $posterJens6->getId(), $posterJens6->getUsername(), 2);
//   $service->addVoter($comment->getId(), $posterJens->getId(), $posterJens->getUsername(), 1);
//    $obj1 = $service->getDownVotersCount($comment->getId());
//    $obj2 = $service->getUpVotersCount($comment->getId());
//    $obj3 = $service->getDiamondVotersCount($comment->getId());
//   
//    Globals::cleanDump($obj1);
//    Globals::cleanDump($obj2);
//    Globals::cleanDump($obj3);
//    echo $service->hasVoted($comment->getId(), $posterJens4->getId());
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}

function addIt($service, $posters) {
    $comment0 = new Comment(1, 1, $posters[0], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);

    $comment0 = new Comment(3, 1, $posters[1], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);

    $comment0 = new Comment(4, 1, $posters[2], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);

    $comment0 = new Comment(5, 1, $posters[3], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);
//
    $comment0 = new Comment(1, 1, $posters[4], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);
    
    $comment0 = new Comment(1, 1, $posters[5], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);
    
     $comment0 = new Comment(5, 1, $posters[0], NULL, 'testing  subcomment 2 added using db', DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE)), NULL, Globals::getDateTimeFormat('be', true));
    $service->addComment($comment0);
}
