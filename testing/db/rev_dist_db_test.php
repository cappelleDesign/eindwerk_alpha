<h1>REVIEW DIST DATABASE TESTING</h1>
<?php
try {
    $obj = 'testing without print';
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
    $reviewDb = new ReviewSqlDB($connection, $commentDb, $genDistDb, $gameDB, $reviewDistDb);

    $now = DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', FALSE));

    $writer = $userDb->getByString('jensAdmin');

    $goods = array(
        'guwd1' => 'guwd1',
        'guwd2' => 'guwd2',
        'guwd3' => 'guwd3'
    );
    $bads = array(
        'bawd1' => 'bawd1',
        'bawd2' => 'bawd2',
        'bawd3' => 'bawd3'
    );
    $tags = array(
        'tawg1' => 'tawg1',
        'tawg2' => 'tawg2',
        'tawg3' => 'tawg3'
    );
//    $reviewDistDb->addUserScore(1, 3, 7);
//    $obj = $reviewDistDb->userRatedReview(1, 5);
//    $reviewDistDb->updateUserScore(1, 3, 6);
//    $reviewDistDb->removeUserScore(1, 3);    
//    $reviewDistDb->addGoodBadTag(1, $goods[0], 'good');
//    $reviewDistDb->addGoodBadTag(1, $bads[0], 'bad');
//    $reviewDistDb->addGoodBadTag(1, $tags[0], 'tag');
//    $obj = $reviewDistDb->searchGBT(1, 'very nice game indeed', 'good');
//    $reviewDistDb->addGoodBadTag(1, 'very nice game indeed', 'good');
//    $reviewDistDb->addGoodBadTagsFull(1, array_values($goods), 'good');
//    $reviewDistDb->removeGoodBadTag(1, 'guwd3', 'good');
//    $reviewDistDb->addHeaderImage(1, 1);
//    $reviewDistDb->updateHeaderImage(1, 5);
//    $reviewDistDb->removeGalleryImage(1, 10);
//    $reviewDistDb->addGalleryImage(1, 10);s
//    $reviewDistDb->addRootComment(1, 1);
//    $reviewDistDb->updateRootCommentNotification(1, 1, 1);
    $reviewDistDb->removeRootComment(1, 1);
    Globals::cleanDump($obj);
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
