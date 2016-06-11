<?php

/**
 * GenreDao
 * This is an interface for all classes that handle genre database functionality
 * @package dao
 * @subpackage dao.review.game.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface GameDistDao {

    /**
     * addGenre
     * Adds a genre to the database
     * @param string $genreName
     * @param string $genreDesc
     */
    public function addGenre($genreName, $genreDesc);

    /**
     * addPlatform
     * Adds a platform to the database
     * @param string $platformName
     */
    public function addPlatform($platformName);

    /**
     * getGenreDesc
     * @param string $genreName
     */
    public function getGenreDesc($genreName);

    /**
     * updateGenre
     * Updates a genre's name and/or description
     * @param string $genreNamePrev
     * @param string $genreName
     * @param string $genreDesc
     */
    public function updateGenre($genreNamePrev, $genreName, $genreDesc);

    /**
     * updatePlatform
     * Updates a platform name
     * @param string $platformPrevName
     * @param string $platformName
     */
    public function updatePlatform($platformPrevName, $platformName);

    /**
     * search
     * Checks if this genre/platform exists
     * @param string objectName
     * @param string $objectNameVal
     * @return int $id if found, NULL otherwise
     */
    public function search($objectName, $objectNameVal);

    /**
     * getAll
     * Returns all genres/platforms from database
     * @param $objectName
     * @return array $genres
     */
    public function getAll($objectName);

    /**
     * addToGame
     * Adds attributes to the game
     * This function is primarily used for adding genres or platforms to a game
     * @param string $objectName
     * @param int $gameId
     * @param string $objectNameVal
     */
    public function addToGame($objectName, $gameId, $objectNameVal);

    /**
     * removeFromGame
     * Removes attributes from the game
     * This function is primarily used for removing genres or platforms from a game
     * @param string $objectName
     * @param int $gameId
     * @param string $objectNameVal
     */
    public function removeFromGame($objectName, $gameId, $objectNameVal);

    /**
     * removeGameLinked
     * Removes linked rows from the game_genre and game_platform tables if 
     * the game id matches
     * @param int $gameId
     */
    public function removeGameLinked($gameId);

    /**
     * getGameAttr
     * Returns an attribute of the game with this id
     * This function is primarily used for getting the genres or platforms for a game
     * @param string $objectName
     * @param int $gameId
     * @return string
     */
    public function getGameAttr($objectName, $gameId);
}
