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
    $reviewDb = new ReviewSqlDB($connection, $commentDb, $genDistDb, $gameDB, $reviewDistDb);
    
    $now = DateFormatter::getNow()->format(Globals::getDateTimeFormat('be', FALSE));

    $genres = array(
        'genre1',
        'genre2'
    );
    $platforms = array(
        'Playstation 4'
    );
    
    $writer =  $userDb->getByString('jensAdmin');
    
    $format = Globals::getDateTimeFormat('be', FALSE);
    $game = new Game('new game', $now, 'www.newGame.be', 'pub1', 'dev1', 2, 16, 4, 2, TRUE, $genres, $platforms, $format);
    
    $headerImg = new Image('qmsdflkj', 'image');
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
    $gallery = array();
    $format = Globals::getDateTimeFormat('be', TRUE);
    $review = new Review($writer, $game, 'Playstation 4', 'New game is amazing', 10, 'bluh bluh bluh', 'yt/qmdlsfkj', $now, $headerImg, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format);

    $obj = $review;
    Globals::cleanDump($obj);
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
