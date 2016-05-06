<?php

class ReviewSqlDB extends SqlSuper implements ReviewsDao {

    private $_reviewDistDB;
    
    private $_commentDB;
    
    private $_generalDistDB;
    
    public function __construct($connection) {
        parent::__construct($connection);
//        $this->init($host, $username, $passwd, $database);
    }
    
    private function init($host, $username, $passwd, $database) {
        
    }

    public function add(DaoObject $daoObject) {
        
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

    public function addGalleryImage($reviewId, Image $image) {
        
    }

    public function addGoodBadTag($reviewId, $goodBadTag) {
        
    }

    public function addRootComment($reviewId, Comment $rootComment) {
        //add to comments table AND to review_has_comments
    }

    public function addUserScore($reviewId, $userId, $userScore) {
        
    }

    public function addVoter($reviewId, $voterId, $voterFlag) {
        
    }

    public function getReviews() {
        
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

    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, Image $headerImg, $goods, $bads, $tags, $gallery, $format) {
        
    }

    public function updateRootcomment($reviewId, $commentId, Comment $rootComment) {
        
    }

    public function updateVoter($reviewId, $voterId, $voterFlag) {
        
    }

}
