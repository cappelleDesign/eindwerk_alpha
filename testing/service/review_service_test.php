<h1>REVIEW SERVICE TESTING</h1 >
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
    $service = new reviewservice($gameDB, $reviewDb, $notifHandler);

    $now = DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', FALSE));
    $nowWithTime = DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', TRUE));
    $genres = array(
        'genre1',
        'genre2'
    );
    $platforms = array(
        'Playstation 4'
    );

    $writer = $userDb->getByString('jensAdmin');
    $writer2 = $userDb->getByString('jens');

    $format = Globals::getDateTimeFormat('be', FALSE);
    $game = new Game('new game', $now, 'www.newGame.be', 'pub1', 'dev1', 2, 16, 4, 2, TRUE, $genres, $platforms, $format);

    $headerImg = new Image('qmsdflkj', 'image');
    $headerImg2 = new Image('add header test', 'image alt');
    $galleryPic1 = new Image('add gallery pic test', 'img alt');
    $poster = $userDb->get(1);
    $poster2 = $userDb->get(2);
    $rootComment1 = new Comment(NULL, NULL, $poster, NULL, 'first comment with notification fingers crossed', $nowWithTime, array(), Globals::getDateTimeFormat('be', TRUE));
    $rootComment2 = new Comment(NULL, NULL, $poster2, NULL, 'second comment with notification fingers crossed', $nowWithTime, array(), Globals::getDateTimeFormat('be', TRUE));
    $subComment1 = new Comment(3, 3, $poster, NULL, 'sub comment for testing', $nowWithTime, array(), Globals::getDateTimeFormat('be', TRUE));
    $userScores = array();
    $rootComments = array();
    $voters = array();
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
    $gallery = array(
        '0' => new Image('blkjl', 'image'),
        '1' => new Image('mlqksgj', 'image')
    );
    $format = Globals::getDateTimeFormat('be', false);
    $review = new Review($writer, $game, 'Playstation 4', 'New game is amazing', 10, 'bluh bluh bluh', 'yt/qmdlsfkj', $now, $headerImg, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format);
    $userReview = new Review($writer2, $game, 'Playstation 4', 'USER VERSION New game is amazing', 10, 'bluh bluh bluh', 'yt/qmdlsfkj', $now, $headerImg, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format, 1);

    $img = $genDistDb->getImage(2);
//    $service->addGalleryImageToReview(1, $galleryPic1);
    
//    $revAdmin = $service->getReview(1);
//    $rev1User = $service->getReview(2);
//    $obj = $rev1User;
//    
//    $service->addRootComment($rev1User, $rootComment1);
//    $service->addRootComment($rev1User, $rootComment2);
//    $commentService->addComment($subComment1);
//    $rootComment1->setId(3);
//    $service->removeRootcomment($rev1User, $rootComment1);
//    $service->addUserScore(1, 5, 6);
//    $service->removeReview(2);
//    $obj = $service->hasUserRatedReview(1, 5);

//    
//    $posterJens = $userDb->get(1);
//    $posterJens2 = $userDb->get(2);
//    $posterJens3 = $userDb->get(3);
//    $posterJens4 = $userDb->get(4);
//    $posterJens5 = $userDb->get(5);
//    $posterJens6 = $userDb->get(6);
//    
//    $review2 = $reviewDb->get(2);
//    
//    $service->addVoter($review2->getId(), $posterJens->getId(),$posterJens->getUsername(), 3);
//    $service->addVoter($review2->getId(), $posterJens2->getId(),$posterJens2->getUsername(),3);
//    $service->addVoter($review2->getId(), $posterJens3->getId(),$posterJens3->getUsername(), 1);
//    $service->addVoter($review2->getId(), $posterJens4->getId(),$posterJens4->getUsername(), 3);
//    $service->addVoter($review2->getId(), $posterJens5->getId(),$posterJens5->getUsername(), 3);
//    $service->addVoter($review2->getId(), $posterJens6->getId(),$posterJens6->getUsername(), 1);
    

    Globals::cleanDump($obj);
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
