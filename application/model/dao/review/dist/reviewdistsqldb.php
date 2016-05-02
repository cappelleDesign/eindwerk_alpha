<?php

class ReviewDistSqlDB extends SqlSuper implements ReviewDistDao {

    /**
     * An instance of the general dist database to help create some objects
     * @var GeneralDistDao 
     */
    private $_generalDistDao;

    public function __construct($host, $username, $passwd, $database, $generalDistDao) {
        parent::__construct('mysql:host=' . $host, $username, $passwd, $database);
        $this->init($generalDistDao);
    }

    private function init($generalDistDao) {
        $this->_generalDistDao = $generalDistDao;
    }

    public function addGalleryImage($reviewId, Image $image) {
        
    }

    public function addGoodBadTag($reviewId, $goodBadTag) {
        
    }

    public function addRootComment($reviewId, Comment $rootComment) {
        
    }

    public function addUserScore($reviewId, $userId, $userScore) {
        
    }

    public function addVoter($reviewId, $voterId, $voterFlag) {
        
    }

    public function removeGalleryImage($reviewId, $imageId) {
        
    }

    public function removeGoodBadTag($reviewId, $goodBadTagId) {
        
    }

    public function removeRootComment($reviewId, $commentId) {
        
    }

    public function removeUserScore($reviewId, $userId) {
        
    }

    public function removeVoter($reviewId, $voterId) {
        
    }

    public function udpateUserScore($reviewId, $userId, $newScore) {
        
    }

    public function updateGame($reviewId, Game $game) {
        
    }

    public function updateRootcomment($reviewId, $commentId, Comment $rootComment) {
        
    }

    public function updateVoter($reviewId, $voterId, $voterFlag) {
        
    }

}
