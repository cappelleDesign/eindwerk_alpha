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

    /**
     * game table
     * @var string 
     */
    private $_gameT;

    public function __construct($connection, $gameDistDb) {
        parent::__construct($connection);
        $this->init($gameDistDb);
    }

    private function init($gameDistDb) {
        $this->_gameDistDb = $gameDistDb;
        $this->_gameT = Globals::getTableName('game');
    }

    /**
     * add
     * Adds a Game to the database
     * @param DaoObject $game
     * @return int $gameId
     * @throws DBException
     */
    public function add(DaoObject $game) {
        if (!$game instanceof Game) {
            throw new DBException('The object you tried to add was not a game object', NULL);
        }
        if ($this->getByString($game->getName())) {
            throw new DBException('The database already contains a game with this name', NULL);
        }
        $query = $this->buildAddQuery();
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':name' => $game->getName(),
            ':release' => $game->getRelease()->format(Globals::getDateTimeFormat('mysql', FALSE)),
            ':site' => $game->getOfficialWebsite(),
            ':publisher' => $game->getPublisher(),
            ':developer' => $game->getDeveloper(),
            ':onlineMin' => $game->getMinPlayersOnline(),
            ':onlineMax' => $game->getMaxPlayersOnline(),
            ':offlineMax' => $game->getMaxPlayersOffline(),
            ':storyMax' => $game->getMaxPlayersStory(),
            ':hasStory' => $game->getHasStoryMode()
        );
        $statement->execute($queryArgs);
        $gameId = parent::getLastId();
        foreach ($game->getGenres() as $genre) {
            $this->addGenreToGame($gameId, $genre);
        }
        foreach ($game->getPlatforms() as $platform) {
            $this->addPlatformToGame($gameId, $platform);
        }
        return $gameId;
    }

    /**
     * get
     * Returns the game with this id from the database
     * @param int $id
     * @return Game
     */
    public function get($id) {
        parent::triggerIdNotFound($id, 'game');
        $query = $this->buildGetQuery('game_id');
        $game = $this->getGame($id, $query);
        return $game;
    }

    /**
     * getByString
     * Returns the game with this name from the database
     * @param string $identifier
     * @return Game
     */
    public function getByString($identifier) {
        $query = $this->buildGetQuery('game_name');
        $game = $this->getGame($identifier, $query);
        return $game;
    }

    /**
     * updateGame
     * Updates the game for this review
     * @param int $gameId
     * @param Game $game
     */
    public function updateGameCore($gameId, Game $game) {
        parent::triggerIdNotFound($gameId, 'game');
        $nameGame = $this->getByString($game->getName());
        if($nameGame && $nameGame->getId() !== $gameId ){
            throw new DBException('Could not update the name of the game because that name is already taken.');
        }
        $query = $this->buildUpdateQuery();
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':name' => $game->getName(),
            ':release' => $game->getRelease()->format(Globals::getDateTimeFormat('mysql', false)),
            ':site' => $game->getOfficialWebsite(),
            ':publisher' => $game->getPublisher(),
            ':developer' => $game->getDeveloper(),
            ':onlineMin' => $game->getMinPlayersOnline(),
            ':onlineMax' => $game->getMaxPlayersOnline(),
            ':offlineMax' => $game->getMaxPlayersOffline(),
            ':storyMax' => $game->getMaxPlayersStory(),
            ':hasStory' => $game->getHasStoryMode(),
            ':id' => $gameId
        );
        $statement->execute($queryArgs);
    }

    /**
     * Remove
     * Deletes a game from the database + all links with genres/platforms
     * @param int $id
     * @throws DBException
     */
    public function remove($id) {
        try {
            $this->_gameDistDb->removeGameLinked($id);
            parent::triggerIdNotFound($id, 'game');
            $query = 'DELETE ';
            $query .='  FROM ' . $this->_gameT;
            $query .= ' WHERE game_id = :gameId';
            $statement = parent::prepareStatement($query);
            $queryArgs = array(
                ':gameId' => $id
            );
            $statement->execute($queryArgs);
        } catch (Exception $ex) {
            throw new DBException($ex->getMessage(), $ex);
        }
    }

    /**
     * addGenreToGame
     * Adds a genre to the game. If the genre does not yet exist in the database,
     * it will be added.
     * @param int $gameId
     * @param string $genreName     
     */
    public function addGenreToGame($gameId, $genreName) {
        $this->_gameDistDb->addToGame('genre', $gameId, $genreName);
    }

    /**
     * updateGameGenre
     * Updates a game's genre
     * @param int $gameId
     * @param string $genreNamePrev
     * @param string $genreNameNew
     */
    public function updateGameGenre($gameId, $genreNamePrev, $genreNameNew) {
        $this->_gameDistDb->removeFromGame('genre', $gameId, $genreNamePrev);
        $this->_gameDistDb->addToGame('genre', $gameId, $genreNameNew);
    }

    /**
     * removeGenreFromGame
     * Removes a genre from a game
     * @param int $gameId
     * @param string $genreName
     */
    public function removeGenreFromGame($gameId, $genreName) {
        $this->_gameDistDb->removeFromGame('genre', $gameId, $genreName);
    }

    /**
     * addPlatformToGame
     * Adds a platform to the game
     * @param int $gameId
     * @param string $platformName
     */
    public function addPlatformToGame($gameId, $platformName) {
        $this->_gameDistDb->addToGame('platform', $gameId, $platformName);
    }
    
    /**
     * search
     * Checks if this genre/platform exists
     * @param string objectName
     * @param string $objectNameVal
     * @return int $id if found, NULL otherwise
     */
    public function search($objectName, $objectNameVal) {
        return $this->_gameDistDb->search($objectName, $objectNameVal);
    }

    /**
     * updateGamePlatform
     * Updates a game's platform
     * @param int $gameId
     * @param string $platformNamePrev
     * @param string $platformNameNew
     */
    public function updateGamePlatform($gameId, $platformNamePrev, $platformNameNew) {
        $this->_gameDistDb->removeFromGame('platform', $gameId, $platformNamePrev);
        $this->_gameDistDb->addToGame('platform', $gameId, $platformNameNew);
    }

    /**
     * removePlatformFromGame
     * Removes a platform from a game
     * @param int $gameId
     * @param string $platformName
     */
    public function removePlatformFromGame($gameId, $platformName) {
        $this->_gameDistDb->removeFromGame('platform', $gameId, $platformName);
    }

    /**
     * getGameGenres
     * Returns all genres for this game
     * @param int $gameId
     */
    public function getGameGenres($gameId) {
        return $this->_gameDistDb->getGameAttr('genre', $gameId);
    }

    /**
     * getGamePlatforms
     * Returns all platforms for this game
     * @param int $gameId
     */
    public function getGamePlatforms($gameId) {
        return $this->_gameDistDb->getGameAttr('platform', $gameId);
    }

    /* ------------------------------------
      HELPER FUNCTIONS
      ------------------------------------ */

    /**
     * createGame
     * Creates and returns a game object
     * @param array $row
     * @return Game
     */
    private function createGame($row) {
        $platforms = $this->getGamePlatforms($row['game_id']);
        $genres = $this->getGameGenres($row['game_id']);
        return parent::getCreationHelper()->createGame($row, $platforms, $genres);
    }

    /**
     * buildAddQuery
     * Helper function that returns the query to add a game
     * @return string
     */
    private function buildAddQuery() {
        $query = 'INSERT INTO ' . $this->_gameT;
        $query .= '(game_name, game_release, game_website, game_publisher, ';
        $query .='game_developer, min_online_players, max_online_players, ';
        $query.= 'max_offline_players, story_max_players, has_storymode)';
        $query.= 'VALUES (:name, :release, :site, :publisher, :developer, '
                . ':onlineMin, :onlineMax, :offlineMax, :storyMax, :hasStory)';
        return $query;
    }

    private function buildUpdateQuery() {
        $query = 'UPDATE ' . $this->_gameT;
        $query .= ' SET game_name = :name, game_release = :release, ';
        $query .= 'game_website = :site, game_publisher = :publisher, ';
        $query .='game_developer = :developer, min_online_players = :onlineMin, ';
        $query .= 'max_online_players = :onlineMax, max_offline_players = :offlineMax, ';
        $query .= 'story_max_players = :storyMax , has_storymode = :hasStory';
        $query .= ' WHERE game_id = :id';        
        return $query;
    }

    /**
     * buildGetQuery
     * Helper function that returns the query to get a game.
     * The whereCol is the column that has to match for the search
     * @param string $whereCol
     * @return string
     */
    private function buildGetQuery($whereCol) {
        $query = 'SELECT * FROM ' . $this->_gameT . ' WHERE ' . $whereCol . ' = ?';
        return $query;
    }

    /**
     * getGame
     * Helper function to return a game 
     * This function is used by the get and the getbystring function
     * @param int $id
     * @param string $query
     * @return Game
     */
    private function getGame($id, $query) {
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        if ($result) {
            return $this->createGame($result);
        } else {
            return null;
        }
    }

}
