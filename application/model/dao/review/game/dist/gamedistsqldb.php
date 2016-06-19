<?php

/**
 * GameDistSqlDB
 * This is a class that handles game dist SQL database functions
 * @package dao
 * @subpackage dao.review.game.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class GameDistSqlDB extends SqlSuper implements GameDistDao {

    private $_genreT;
    private $_platT;

    public function __construct($connection) {
        parent::__construct($connection);
        $this->init();
    }

    private function init() {
        $this->_genreT = Globals::getTableName('genre');
        $this->_platT = Globals::getTableName('platform');
    }

    /**
     * addGenre
     * Adds a genre to the database
     * @param string $genreName
     * @param string $genreDesc
     */
    public function addGenre($genreName, $genreDesc) {
        $genreId = $this->search('genre', $genreName);
        if ($genreId) {            
            if ($this->getGenreDesc($genreName) !== $genreDesc) {
                $this->updateGenre($genreName, $genreName, $genreDesc);
                return $genreId;
            }
        } else {
            $query = 'INSERT INTO ' . $this->_genreT . ' (genre_name, genre_description)';
            $query .= ' VALUES (:name, :desc)';
            $statement = parent::prepareStatement($query);
            $queryArgs = array(
                ':name' => $genreName,
                ':desc' => $genreDesc
            );
            $statement->execute($queryArgs);
            return parent::getLastId();
        }
    }

    /**
     * addPlatform
     * Adds a platform to the database
     * @param string $platformName
     */
    public function addPlatform($platformName) {
        $platformId = $this->search('platform', $platformName);
        if (!$platformId) {
            $query = 'INSERT INTO ' . $this->_platT . ' (platform_name)';
            $query .= ' VALUES (:name)';
            $statement = parent::prepareStatement($query);
            $queryArgs = array(
                ':name' => $platformName
            );
            $statement->execute($queryArgs);
            $platformId = parent::getLastId();
        }
        return $platformId;
    }

    /**
     * getGenreDesc
     * Returns the description for this genre
     * @return string
     * @param string $genreName
     */
    public function getGenreDesc($genreName) {
        $query = 'SELECT genre_description FROM ' . $this->_genreT . ' WHERE genre_name = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $genreName);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        return $result['genre_description'];
    }

    /**
     * updateGenre
     * Updates a genre's name and/or description
     * @param string $genreNamePrev
     * @param string $genreName
     * @param string $genreDesc
     */
    public function updateGenre($genreNamePrev, $genreName, $genreDesc) {
        $query = 'UPDATE ' . $this->_genreT;
        $query .= ' SET genre_name = :name, genre_description = :desc';
        $query .= ' WHERE genre_name = :prevName';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':name' => $genreName,
            'desc' => $genreDesc,
            ':prevName' => $genreNamePrev
        );
        $statement->execute($queryArgs);
    }

    /**
     * updatePlatform
     * Updates a platform name
     * @param string $platformPrevName
     * @param string $platformName
     */
    public function updatePlatform($platformPrevName, $platformName) {
        $query = 'UPDATE ' . $this->_platT;
        $query .= ' SET platform_name = :name';
        $query .= ' WHERE platform_name = :namePrev';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':name' => $platformName,
            ':namePrev' => $platformPrevName
        );
        $statement->execute($queryArgs);
    }

    /**
     * search
     * Checks if this genre/platform exists
     * @param string objectName
     * @param string $objectNameVal
     * @return int $id if found, NULL otherwise
     */
    public function search($objectName, $objectNameVal) {
        $table = Globals::getTableName($objectName);
        $query = 'SELECT ' . $objectName . '_id' . ' as found FROM ' . $table . ' WHERE ' . $objectName . '_name = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $objectNameVal);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        return $result['found'];
    }

    /**
     * getAll
     * Returns all genres/platforms from database
     * @param $objectName
     * @return array 
     */
    public function getAll($objectName) {
        $table = Globals::getTableName($objectName);
        $query = 'SELECT * FROM ' . $table;
        $statement = parent::prepareStatement($query);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        return $result;
    }

    /**
     * addToGame
     * Adds attributes to the game
     * This function is primarily used for adding genres or platforms to a game
     * @param string $objectName
     * @param int $gameId
     * @param string $objectNameVal
     */
    public function addToGame($objectName, $gameId, $objectNameVal) {
        $id = $this->search($objectName, $objectNameVal);
        $query = 'INSERT INTO ' . Globals::getTableName('game_' . $objectName);
        $query .= ' (game_id, ' . $objectName . '_id)';
        $query .= 'VALUES(:gameId, :objectId)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':gameId' => $gameId,
            ':objectId' => $id
        );
        $statement->execute($queryArgs);
    }

    /**
     * removeFromGame
     * Removes attributes from the game
     * This function is primarily used for removing genres or platforms from a game
     * @param string $objectName
     * @param int $gameId
     * @param string $objectNameVal
     */
    public function removeFromGame($objectName, $gameId, $objectNameVal) {
        $table = Globals::getTableName('game_' . $objectName);
        $idCole = $objectName . '_id';
        $rmId = $this->search($objectName, $objectNameVal);
        $query = 'DELETE FROM ' . $table . ' WHERE game_id = :gameId AND ' . $idCole . '= :rmId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':gameId' => $gameId,
            ':rmId' => $rmId
        );
        $statement->execute($queryArgs);        
    }

    /**
     * removeGameLinked
     * Removes linked rows from the game_genre and game_platform tables if 
     * the game id matches
     * @param int $gameId
     */
    public function removeGameLinked($gameId) {
        $query = 'DELETE gg, gp';
        $query .= ' FROM ' . Globals::getTableName('game_genre') . ' gg, ' . Globals::getTableName('game_platform') . ' gp';
        $query .= ' WHERE gg.game_id = :gameId1 AND gp.game_id = :gameId2';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':gameId1' => $gameId,
            ':gameId2' => $gameId
        );
        $statement->execute($queryArgs);
    }

    /**
     * getGameAttr
     * Returns an attribute of the game with this id
     * This function is primarily used for getting the genres or platforms for a game
     * @param string $objectName
     * @param int $gameId
     * @return string
     */
    public function getGameAttr($objectName, $gameId) {
        $table = Globals::getTableName($objectName);
        $combo = Globals::getTableName('game_' . $objectName);
        $idCol = $objectName . '_' . 'id';
        $query = 'SELECT ' . $objectName . '_name FROM ' . $table;
        $query .= ' LEFT JOIN ' . $combo . ' ON ' . $table . '.' . $idCol . '=' . $combo . '.' . $idCol;
        $query .= ' WHERE game_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $gameId);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        return $result;
    }

}
