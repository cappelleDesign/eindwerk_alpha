<?php
/**
 * GameSqlDB
 * This is a class that handles game SQL database functions
 * @package dao
 * @subpackage dao.review.game
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class GameSqlDB extends SqlSuper implements GameDao{
    
    /**
     * The game's dist database
     * @var GameDistDao 
     */
    private $_gameDistDb;
    
    public function __construct($connection, $gameDistDb) {
        parent::__construct($connection);
        $this->init($gameDistDb);
    }
    
    private function init($gameDistDb) {
        $this->_gameDistDb = $gameDistDb;
    }
    
    public function add(DaoObject $daoObject) {
        
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

    public function addGenreToGame($gameId, $genreName, $genreDesc) {
        
    }

    public function addPlatformToGame($gameId, $platformName) {
        
    }

    public function removeGenreFromGame($gameId, $genreName) {
        
    }

    public function removePlatformFromGame($gameId, $platformName) {
        
    }

    public function updateGameGenre($gameId, $genreNamePrev, $genreNameNew) {
        
    }

    public function updateGamePlatform($gameId, $platformNamePrev, $platformNameNew) {
        
    }

}
