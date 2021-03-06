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
     * getGameDistDB
     * returns the game dist database
     * @return GameDistDao
     */
    public function getGameDistDB();
    
    /**
     * addGenreToGame
     * Adds a genre to the game. If the genre does not yet exist in the database,
     * it will be added.
     * @param int $gameId
     * @param string $genreName     
     */
    public function addGenreToGame($gameId, $genreName);

    /**
     * getGameGenres
     * Returns all genres for this game
     * @param int $gameId
     */
    public function getGameGenres($gameId);

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
     * search
     * Checks if this genre/platform exists
     * @param string objectName
     * @param string $objectNameVal
     * @return int $id if found, NULL otherwise
     */
    public function search($objectName, $objectNameVal);

    /**
     * getGamePlatforms
     * Returns all platforms for this game
     * @param int $gameId
     */
    public function getGamePlatforms($gameId);

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

    /**
     * updateGame
     * Updates the game in the database
     * @param int $gameId
     * @param Game $game
     */
    public function updateGameCore($gameId, Game $game);
}
