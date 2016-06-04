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
        if ($this->search('genre', $genreName)) {
            if ($this->getGenreDesc($genreName) !== $genreDesc) {
                $this->updateGenre($genreName, $genreName, $genreDesc);
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
        }
    }

    /**
     * addPlatform
     * Adds a platform to the database
     * @param type $platformName
     */
    public function addPlatform($platformName) {
        if (!$this->search('platform', $platformName)) {
            $query = 'INSERT INTO ' . $this->_platT . ' (platform_name)';
            $query .= ' VALUES (:name)';
            $statement = parent::prepareStatement($query);
            $queryArgs = array(
                ':name' => $platformName
            );
            $statement->execute($queryArgs);
        }
    }

    /**
     * getGenreDesc
     * Returns the description for this genre
     * @param type $genreName
     */
    public function getGenreDesc($genreName) {
        Globals::cleanDump('get genre desc');
    }

    public function updateGenre($genreNamePrev, $genreName, $genreDesc) {
        Globals::cleanDump('genre upd');
    }

    public function updatePlatform($platformPrevName, $platformName) {
        Globals::cleanDump('plat upd');
    }

    public function search($objectName, $objectNameVal) {
        $table = Globals::getTableName($objectName);
        $query = 'SELECT COUNT(*) as found FROM ' . $table . ' WHERE ' . $objectName . '_name = ?';        
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $objectNameVal);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        return $result['found'];
    }

    public function getAll($objectName) {
        
    }

}
