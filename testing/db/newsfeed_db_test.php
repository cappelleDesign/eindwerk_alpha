<h1>NEWSFEED DATABASE TESTING</h1 >
<?php
try {
    $obj = 'Test without print';
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $voteDb = new VoteSqlDB($connection);
    $genDistDb = new GeneralDistSqlDB($connection);
    $notifDB = new NotificationSqlDB($connection);
    $userDist = new UserDistSqlDB($connection, $genDistDb, $voteDb);
    $userDb = new UserSqlDB($connection, $userDist, $notifDB);
    $commentDb = new CommentSqlDB($connection, $userDb, $voteDb);
    $gameDistDb = new GameDistSqlDB($connection);
    $gameDB = new GameSqlDB($connection, $gameDistDb);
    $reviewDistDb = new ReviewDistSqlDB($connection, $genDistDb);
    $reviewDb = new ReviewSqlDB($connection, $commentDb, $genDistDb, $gameDB, $reviewDistDb, $voteDb, $userDb);
    $notifHandler = new notificationHandler($userDb, $commentDb, $reviewDb);
    $commentService = new CommentService($commentDb, $notifHandler);

    $newsfeedDB = new NewsfeedSqlDB($connection, $userDb, $genDistDb);

    $now = DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', FALSE));
    $nowWithTime = DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE));
    $format = Globals::getDateTimeFormat('be', True);
    $writer = $userDb->get(7);
    $img = $genDistDb->getImage(1);
    $imgUpd = $genDistDb->getImage(2);

    $body = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident, quisquam, velit, quidem, ipsam praesentium ducimus voluptates veniam temporibus neque sit voluptatem alias eos qui? Pariatur consequuntur quisquam natus odit ut .';
    $newsfeed = new NewsfeedItem($writer->getId(), $writer->getUsername(), $img, 'NEWSFEED SUBJECT', $body, $nowWithTime, $format);

//    $newsfeedDB->add($newsfeed);
//    $obj = $newsfeedDB->get(1);
//    $obj = $newsfeedDB->getByString('Dummy subject one');
//    $options = array(
//        'limit' => 3
//    );
//    $obj = $newsfeedDB->getNewsfeed($options);
//    $newsfeedDB->updateNewsfeedItemBody(1, 'body upd');
//    $newsfeedDB->updateNewsfeedItemSubject(1, 'subj upd');
//    $newsfeedDB->updateNewsfeedItemImage(1, $imgUpd);
    Globals::cleanDump($obj);
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
