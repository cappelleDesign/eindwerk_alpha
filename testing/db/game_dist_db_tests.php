<?php

echo '<h1>GAME DIST TESTING</h1>';
try {
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    $gdDb = new GameDistSqlDB($connection);
    
    $genreNameNew = 'Gangsta3';
    $genreDesc = 'About gangsters3';
    
    $platformName = 'ps360';
    $platformNameNew = 'ps720';
        
    
//    $gdDb->addGenre($genreNameNew, $genreDesc);
//    $gdDb->addPlatform($platformName);
//    $gdDb->updatePlatform($platformName, $platformNameNew);
    Globals::cleanDump($gdDb->getAll('platform'));
    Globals::cleanDump($gdDb->getAll('genre'));
    echo '<h1 style="color: green">NO ERRORS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}