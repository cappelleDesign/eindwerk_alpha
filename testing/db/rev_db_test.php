<h1>REVIEW DATABASE TESTING</h1>
<?php

try {
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $voteDb = new VoteSqlDB($connection);
    $genDistDb = new GeneralDistSqlDB($connection);
    $notifDB = new NotificationSqlDB($connection);
    $userDist = new UserDistSqlDB($connection, $genDistDb, $voteDb);
    $userDb = new UserSqlDB($connection, $voteDb, $genDistDb);
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
    
    $format = Globals::getDateTimeFormat('be', TRUE);
    $review = new Review($writer, $game, 'Playstation 4', 'New game is amazing', $score, $text, $videoUrl, $created, $headerImg, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format);
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
