<h1>USER DIST DATABASE TESTING</h1>
<?php

try {
    $obj = 'testing without print';
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $voteDb = new VoteSqlDB($connection);
    $genDistDb = new GeneralDistSqlDB($connection);
    $notifDB = new NotificationSqlDB($connection);
    $userDist = new UserDistSqlDB($connection, $genDistDb, $voteDb);
//    $userDb = new UserSqlDB($connection, $userDist, $notifDB);
//    $commentDb = new CommentSqlDB($connection, $userDb, $voteDb);

    
    
    
    
    Globals::cleanDump($obj);    
    echo '<h1 style="color: green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
