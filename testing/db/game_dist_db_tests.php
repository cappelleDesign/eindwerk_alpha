<?php

echo '<h1>GAME DIST TESTING</h1>';
try {
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $gdDb = new GameDistSqlDB($connection);
    
    $genreNameNew = 'Gangsta3';
    $genreDesc = 'About gangsters';
    
    $platformName = 'ps360';
        
    
//    $gdDb->addGenre($genreNameNew, $genreDesc);
    $gdDb->addPlatform($platformName);
    
    echo '<h1 style="color: green">NO ERRORS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}