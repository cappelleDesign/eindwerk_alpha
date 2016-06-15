<?php

/**
 * DaoFactory
 * This is a class that functions as a factory class to get database subclasses
 * @package dao
 * @subpackage dao
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class DaoFactory {

    private $_connection;

    public function __construct() {
        
    }

    /**
     * getSupportedTypes
     * Returns all the supported database types
     * @return string
     */
    public function getSupportedTypes() {
        $supported = array('mysql');
        return $supported;
    }

    /* GENERAL DAO'S */

    /**
     * getNewsfeedDB
     * Returns a newsfeed database with the type depending on the configs
     * @param array $configs
     * @param UserDao $userDao
     * @param GeneralDistDao $genDistDao
     * @return NewsfeedDao
     * @throws DBException
     */
    public function getNewsfeedDB($configs, UserDao $userDao, GeneralDistDao $genDistDao) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $newsfeedDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $newsfeedDB = new NewsfeedSqlDB($this->_connection, $userDao, $genDistDao);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for newsfeed: ' . $dbType, NULL);
        }
        return $newsfeedDB;
    }

    /**
     * getCommentDB
     * Returns a comment database with the type depending on the configs
     * @param array $configs
     * @param UserDao $userDao
     * @param VoteDao $voteDao
     * @return CommentDao
     * @throws DBException
     */
    public function getCommentDB($configs, UserDao $userDao, VoteDao $voteDao) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $commentDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $commentDB = new CommentSqlDB($this->_connection, $userDao, $voteDao);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for comment: ' . $dbType, NULL);
        }
        return $commentDB;
    }

    /**
     * getVoteDB
     * Returns a Vote database with the type depending on the configs
     * @param array $configs
     * @return VoteDao
     * @throws DBException
     */
    public function getVoteDB($configs) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $voteDb = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $voteDb = new VoteSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for votes: ' . $dbType, NULL);
        }
        return $voteDb;
    }

    /**
     * geGeneralDistDB
     * Returns a user database with the type depending on the configs
     * @param array $configs
     * @return UserDao
     * @throws DBException
     */
    public function getGeneralDistDB($configs) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $generalDistDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $generalDistDB = new GeneralDistSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for general dist: ' . $dbType, NULL);
        }
        return $generalDistDB;
    }

    /* REVIEW RELATED DAO'S */

    /**
     * getGameDistDB
     * Returns a game dist database with the type depending on the configs
     * @param array $configs
     * @return GameDistDao
     * @throws DBException
     */
    public function getGameDistDB($configs) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $gameDistDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $gameDistDB = new GameDistSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for game dist: ' . $dbType, NULL);
        }
        return $gameDistDB;
    }

    /**
     * getGameDB
     * Returns a game database with the type depending on the configs
     * @param array $configs
     * @param GameDistDao $gameDistDao
     * @return GameDao
     * @throws DBException
     */
    public function getGameDB($configs, GameDistDao $gameDistDao) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $gameDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $gameDB = new GameSqlDB($this->_connection, $gameDistDao);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for game: ' . $dbType, NULL);
        }
        return $gameDB;
    }

    /**
     * getReviewDB
     * Returns a review database with the type depending on the configs
     * @param array $configs
     * @param CommentDao $commentDoa
     * @param GeneralDistDao $genDistDao
     * @param GameDao $gameDB
     * @param ReviewDistDao $reviewDistDB
     * @param VoteDao $voteDB
     * @param UserDao $userDB
     * @return ReviewDao
     * @throws DBException
     */
    public function getReviewDB($configs, CommentDao $commentDoa, GeneralDistDao $genDistDao, GameDao $gameDB, ReviewDistDao $reviewDistDB, VoteDao $voteDB, UserDao $userDB) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $reviewDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $reviewDB = new ReviewSqlDB($this->_connection, $commentDoa, $genDistDao, $gameDB, $reviewDistDB, $voteDB, $userDB);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for review: ' . $dbType, NULL);
        }
        return $reviewDB;
    }

    /**
     * getReviewDistDB
     * Returns a review dist database with the type depending on the configs
     * @param array $configs
     * @param GeneralDistDao $genDistDao
     * @return ReviewDistDao
     * @throws DBException
     */
    public function getReviewDistDB($configs, GeneralDistDao $genDistDao) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $reviewDistDao = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $reviewDistDao = new ReviewDistSqlDB($this->_connection, $genDistDao);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for review dist: ' . $dbType, NULL);
        }
        return $reviewDistDao;
    }

    /* USER RELATED DAO'S */

    /**
     * getUserDB
     * Returns a user database with the type depending on the configs
     * @param array $configs
     * @param UserDistDao $userDistDao
     * @param NotificationDao $notificationDao
     * @return UserDao
     * @throws DBException
     */
    public function getUserDB($configs, UserDistDao $userDistDao, NotificationDao $notificationDao) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $userDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $userDB = new UserSqlDB($this->_connection, $userDistDao, $notificationDao);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for users: ' . $dbType, NULL);
        }
        return $userDB;
    }

    /**
     * getUserDistDB
     * Returns a User dist database with the type depending on the configs
     * @param array $configs
     * @param GeneralDistDao $generalDistDao
     * @param VoteDao $voteDao
     * @return UserDistDao
     * @throws DBException
     */
    public function getUserDistDB($configs, GeneralDistDao $generalDistDao, VoteDao $voteDao) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $userDistDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $userDistDB = new UserDistSqlDB($this->_connection, $generalDistDao, $voteDao);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for users: ' . $dbType, NULL);
        }
        return $userDistDB;
    }

    /**
     * getNotificationDB
     * Returns a Notification database with the type depending on the configs
     * @param array $configs
     * @return NotificationDao
     * @throws DBException
     */
    public function getNotificationDB($configs) {
        $this->checkConfigs($configs);
        $dbType = $configs['type'];
        $notificationDB = NULL;
        switch ($dbType) {
            case 'mysql' :
                $this->createMysqlConnection($configs['host'], $configs['username'], $configs['password'], $configs['database']);
                $notificationDB = new NotificationSqlDB($this->_connection);
                break;
            default :
                throw new DBException('This type of database is not (yet) supported for notification: ' . $dbType, NULL);
        }
        return $notificationDB;
    }

    /**
     * checkConfigs
     * Checks if the configs contain all the needed informations for the given type.
     * If no exception is thrown, all needed info was present     
     * @param array $configs
     * @throws DBException
     */
    private function checkConfigs($configs) {
        if (!isset($configs) || !is_array($configs) || empty($configs)) {
            throw new DBException('No valid configuration found', NULL);
        }
        if (!array_key_exists('type', $configs)) {
            throw new DBException('No config found', NULL);
        }
    }

    /**
     * createMysqlConnection
     * If the connection is not yet initialized, it will be set with these settings
     * @param string $host
     * @param string $username
     * @param string $passwd
     * @param string $database
     */
    private function createMysqlConnection($host, $username, $passwd, $database) {
        if (!$this->_connection) {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $database;
            $this->_connection = new PDO($dsn, $username, $passwd);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

}
