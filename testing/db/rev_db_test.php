<h1>REVIEW DATABASE TESTING</h1>
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
    $poster = $userDb->get(5);
    $rootComment1 = new Comment(NULL, NULL, $poster, 1, 'test add comment', $nowWithTime, array(), Globals::getDateTimeFormat('be', TRUE));
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

//    $reviewId = $reviewDb->add($review);
//    $userReviewId = $reviewDb->add($userReview);    
//     $reviewDb->addGood($reviewId, 'add good test');
//    $reviewDb->addBad($reviewId, 'add bad test');
//     $reviewDb->addTag($reviewId, 'add tag test');
//     $reviewDb->addGalleryImage($reviewId, $galleryPic1);
//     $reviewDb->addHeaderImage($reviewId, $headerImg2);     
//     $reviewDb->addRootComment($reviewId, $rootComment1);   
//     $reviewDb->addUserScore($reviewId, $poster->getId(), 5);
//     $reviewDb->addVoter($reviewId, $poster->getId(), 2, 3);
//    $obj = $reviewDb->get(1);
//    $obj = $reviewDb->getByString('Game1: The good, the bad and the ugly');
//    $obj = $reviewDb->getGame(1);
//    $obj = $reviewDb->getGoods(1);
//    $obj = $reviewDb->getBads(1);
//    $obj = $reviewDb->getTags(1);
//    $obj = $reviewDb->getGallery(1);
//    $obj = $reviewDb->getHeaderImage(1);
//    $obj = $reviewDb->getRootComments(1);
//    $obj = $reviewDb->getUserScores(1);
//    $obj = $reviewDb->getVotedNotifId(1, 3);
//    $obj = $reviewDb->getVoters(1);
//    $obj = $reviewDb->getVoters(1, 1);
//    $obj = $reviewDb->getVoters(1, 2);
//    $obj = $reviewDb->getVoters(1, 3);
//    $obj = $reviewDb->getVotersCount(1, 1);
//    $obj = $reviewDb->getVotersCount(1, 2);
//    $obj = $reviewDb->getVotersCount(1, 3);   
    $options = array(
        'whereOptions' => array(
            'txt' => 'ipsum'
        ),
        'havingOptions' => array(
            'minScore' => 8,
            'maxScore' => 10
        ),
        'orderOptions' => array(
            'col' => 'review_created',
            'order' => 'DESC'
        ),
        'limitOptions' => array(
            'limit' => 3
        )
    );
    $obj = $reviewDb->getReviews($options);
//    $obj = $reviewDb->getUserReviewsForGame(1);
//    $obj = $reviewDb->getUserReviewForGameAndUser(1, 2);
//    $obj = $reviewDb->getUserReviewsForUser(2);

    Globals::cleanDump($obj);
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
