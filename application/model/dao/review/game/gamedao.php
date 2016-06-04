<?php

/**
 * GameDao
 * This is an interface for all classes that handle game database functionality
 * @package dao
 * @subpackage dao.review.game
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface GameDao extends Dao {        
    
    /**
     * addGenreToGame
     * Adds a genre to the game. If the genre does not yet exist in the database,
     * it will be added.
     * @param int $gameId
     * @param string $genreName
     * @param string $genreDesc
     */
    public function addGenreToGame($gameId, $genreName, $genreDesc);           

    /**
     * updateGameGenre
     * Updates a game's genre
     * @param int $gameId
     * @param string $genreNamePrev
     * @param string $genreNameNew
     */
    public function updateGameGenre($gameId, $genreNamePrev, $genreNameNew);

    /**
     * removeGenreFromGame
     * Removes a genre from a game
     * @param int $gameId
     * @param string $genreName
     */
    public function removeGenreFromGame($gameId, $genreName);

    /**
     * addPlatformToGame
     * Adds a platform to the game
     * @param int $gameId
     * @param string $platformName
     */
    public function addPlatformToGame($gameId, $platformName);    

    /**
     * updateGamePlatform
     * Updates a game's platform
     * @param int $gameId
     * @param string $platformNamePrev
     * @param string $platformNameNew
     */
    public function updateGamePlatform($gameId, $platformNamePrev, $platformNameNew);
    
    /**
     * removePlatformFromGame
     * Removes a platform from a game
     * @param int $gameId
     * @param string $platformName
     */
    public function removePlatformFromGame($gameId, $platformName);
}
