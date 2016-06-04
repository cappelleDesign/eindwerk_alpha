<?php
/**
 * ReviewDistSqlDB
 * This is a class that handles review dist SQL database functions
 * @package dao
 * @subpackage dao.review.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewDistSqlDB extends SqlSuper implements ReviewDistDao {

    /**
     * An instance of the general dist database to help create some objects
     * @var GeneralDistDao 
     */
    private $_genDistDao;

    public function __construct($connection, $genDistDb) {
        parent::__construct($connection);
        $this->init($genDistDb);
    }

    private function init($generalDistDao) {
        $this->_genDistDao = $generalDistDao;
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

    public function updateVoter($reviewId, $voterId, $voterFlag) {
        
    }


}
