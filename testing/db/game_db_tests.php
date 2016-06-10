<?php

echo '<h1>GAME TESTING</h1>';
try {
    $connection = new PDO('mysql:host=127.0.0.1;dbname=soufitq169_neoludus', 'neoludus_admin', 'Admin001');
    
    $gdDb = new GameDistSqlDB($connection);
        
    $gdDb->addGenre('genre4', 'genre4 desc');
    $gdDb->addPlatform('plat720');

    
    $gdb = new GameSqlDB($connection, $gdDb);
    
    $platforms = array('Playstation 4', 'Xbox one');
    $genres = array('genre1','genre2');
    $game  = new Game('game', '21/10/2014', 'www.game.be', 'pub', 'dev', 2, 4, 4, 2, 1, $genres, $platforms, Globals::getDateTimeFormat('be', false));    
    $obj = '';
 
//    $gdb->addGenreToGame(1, 'genre3');
//    $gdb->addPlatformToGame(1, 'plat360');           
//    $obj = $gdb->getGameGenres(1);
//    $gdb->updateGameGenre(1, 'genre3', 'genre4');
//    $gdb->removeGenreFromGame(1, 'genre4');
//    $obj = $gdb->getGamePlatforms(1);
//    $gdb->updateGamePlatform(1, 'plat360', 'plat720');
//    $gdb->removePlatformFromGame(1, 'plat720');
//    $gdb->add($game);
    
//    $obj = $gdb->get(1);
//    $obj = $gdb->getByString('game');
    
//    $gdb->updateGameCore(1, $game);
//    $gdb->remove(2);
    Globals::cleanDump($obj);
    
    
    echo '<h1 style="color: green">NO ERRORS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}