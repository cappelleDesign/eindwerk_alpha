<?php

/**
 * GameSqlDB
 * This is a class that handles game SQL database functions
 * @package dao
 * @subpackage dao.review.game
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class GameSqlDB extends SqlSuper implements GameDao {

    /**
     * The game's dist database
     * @var GameDistDao 
     */
    private $_gameDistDb;

    private $_gameT;
    
    public function __construct($connection, $gameDistDb) {
        parent::__construct($connection);
        $this->init($gameDistDb);
    }

    private function init($gameDistDb) {
        $this->_gameDistDb = $gameDistDb;
        $this->_gameT = Globals::getTableName('game');
    }

    public function add(DaoObject $game) {
        if (!$game instanceof Game) {
            throw new DBException('The object you tried to add was not a game object', NULL);
        }
        if (parent::containsId($game->getId(), 'game')) {
            throw new DBException('The database already contains a game with this id', NULL);
        }
        if($this->containsName($game->getName())) {
            throw new DBException('The database already contains a gem with this name',NULL);
        }
        $query = 'INSERT INTO ' . $this->_gameT ;
        $query .= '(game_name, game_release, game_website, game_publisher, ';
        $query .='game_developer, min_online_players, max_online_players, ';
        $query.= 'max_offline_players, story_max_players, has_storymode)';
        $query.= 'VALUES ()';
    } 
    
    public function containsName($name) {
        try {
            $this->getByString($name);
            return true;
        } catch (Exception $ex) {
            return false;
        }
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
