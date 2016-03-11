<?php

/**
 * Game
 * @package model
 * @subpackage domain.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Game implements DaoObject {

    /**
     * The id if the game
     * @var int
     */
    private $_id;

    /**
     * The name of the game
     * @var string
     */
    private $_name;

    /**
     * The releasedate of the game
     * @var DateTime
     */
    private $_release;

    /**
     * The url to the official website of this game
     * @var string
     */
    private $_officialWebsite;

    /**
     * The publisher of this game
     * @var string
     */
    private $_publisher;

    /**
     * The developer of this game
     * @var string
     */
    private $_developer;

    /**
     * Minimum online players for this game
     * @var int
     */
    private $_minPlayersOnline;

    /**
     * Maximum online players for this game
     * @var int
     */
    private $_maxPlayersOnline;

    /**
     * Maximum onffline players for this game
     * @var int
     */
    private $_maxPlayersOffline;

    /**
     * Maximum players for story mode (single player or couch co-op)
     * @var int
     */
    private $_maxPlayersStory;

    /**
     * Wether or not the game has a story mode or is online only
     * @var boolean
     */
    private $_hasStoryMode;

    /**
     * The generes that are associated to this game.
     * assoc array (id, genre name)
     * @var array
     */
    private $_genres;

    /**
     * The platforms this game was released on.
     * assoc array (id, platform name)
     * @var array
     */
    private $_platforms;

    public function __construct($name, $release, $officialWebsite, $publisher, $developer, $minPlayersOnline, $maxPlayersOnline, $maxPlayersOffline, $maxPlayersStory, $hasStoryMode, $genres, $platforms, $format) {
        $this->init();
        $this->setName($name);
        $this->setRelease($release, $format);
        $this->setOfficialWebsite($officialWebsite);
        $this->setPublisher($publisher);
        $this->setDeveloper($developer);
        $this->setMinPlayersOnline($minPlayersOnline);
        $this->setMaxPlayersOnline($maxPlayersOnline);
        $this->setMaxPlayersOffline($maxPlayersOffline);
        $this->setMaxPlayersStory($maxPlayersStory);
        $this->setHasStoryMode($hasStoryMode);
        $this->setGenres($genres);
        $this->setPlatforms($platforms);
    }

    private function init() {
        $this->_genres = [];
        $this->_platforms = [];
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function setRelease($release, $format) {
        $date = DateTime::createFromFormat($format, $release);
        $this->_release = $date;
    }

    public function setOfficialWebsite($officialWebsite) {
        $this->_officialWebsite = $officialWebsite;
    }

    public function setPublisher($publisher) {
        $this->_publisher = $publisher;
    }

    public function setDeveloper($developer) {
        $this->_developer = $developer;
    }

    public function setMinPlayersOnline($minPlayersOnline) {
        $this->_minPlayersOnline = $minPlayersOnline;
    }

    public function setMaxPlayersOnline($maxPlayersOnline) {
        $this->_maxPlayersOnline = $maxPlayersOnline;
    }

    public function setMaxPlayersOffline($maxPlayersOffline) {
        $this->_maxPlayersOffline = $maxPlayersOffline;
    }

    public function setMaxPlayersStory($maxPlayersStory) {
        $this->_maxPlayersStory = $maxPlayersStory;
    }

    public function setHasStoryMode($hasStoryMode) {
        $this->_hasStoryMode = $hasStoryMode;
    }

    public function setGenres($genres) {
        $this->_genres = $genres;
    }

    public function setPlatforms($platforms) {
        $this->_platforms = $platforms;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function getRelease() {
        return $this->_release;
    }

    public function getOfficialWebsite() {
        return $this->_officialWebsite;
    }

    public function getPublisher() {
        return $this->_publisher;
    }

    public function getDeveloper() {
        return $this->_developer;
    }

    public function getMinPlayersOnline() {
        return $this->_minPlayersOnline;
    }

    public function getMaxPlayersOnline() {
        return $this->_maxPlayersOnline;
    }

    public function getMaxPlayersOffline() {
        return $this->_maxPlayersOffline;
    }

    public function getMaxPlayersStory() {
        return $this->_maxPlayersStory;
    }

    public function getHasStoryMode() {
        return $this->_hasStoryMode;
    }

    public function getGenres() {
        return $this->_genres;
    }

    public function getPlatforms() {
        return $this->_platforms;
    }

    /**
     * addGenre
     * Adds a genre to this game
     * @param type $genreId
     * @param type $genreName
     */
    public function addGenre($genreId, $genreName) {
        $this->_genres[$genreId] = $genreName;
    }

    /**
     * removeGenre
     * Removes a genre from this game
     * @param type $genreId     
     */
    public function removeGenre($genreId) {
        if (array_key_exists($genreId, $this->getGenres())) {
            unset($this->_genres[$genreId]);
        }
    }

    /**
     * addPlatform
     * Adds a platform to this game
     * @param type $platformId
     * @param type $platformName
     */
    public function addPlatform($platformId, $platformName) {
        $this->_platforms[$platformId] = $platformName;
    }

    /**
     * removePlatform
     * Removes a platform from this game
     * @param type $platformId     
     */
    public function removePlatform($platformId) {
        if (array_key_exists($platformId, $this->getPlatforms())) {
            unset($this->_genres[$platformId]);
        }
    }

    /**
     * getReleaseStr
     * returns the release date and time as string with given format.
     * format should be a php datetime format string.
     * @param string $format
     * @return string
     */
    public function getReleaseStr($format) {
        return $this->getRelease()->format($format);
    }

}
