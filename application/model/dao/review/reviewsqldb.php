<?php

/**
 * ReviewSqlDB
 * This is a class that handles review SQL database functions
 * @package dao
 * @subpackage dao.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewSqlDB extends SqlSuper implements ReviewDao {

    private $_reviewDistDB;
    private $_commentDB;
    private $_genDistDB;
    private $_gameDB;
    private $_revT;

    public function __construct($connection, $commentDb, $genDistDb, $gameDistDb) {
        parent::__construct($connection);
        $this->init($connection, $commentDb, $genDistDb, $gameDistDb);
    }

    private function init($connection, $commentDb, $genDistDb, $gameDistDb) {
        $this->_commentDB = $commentDb;
        $this->_genDistDB = $genDistDb;
        $this->_reviewDistDB = new ReviewDistSqlDB($connection, $genDistDb);
        $this->_gameDB = new GameSqlDB($connection, $gameDistDb);
        $this->_revT = Globals::getTableName('review');
    }

    public function add(DaoObject $review) {
        if (!$review instanceof Review) {
            throw new DBException('The object you tried to add was not a review object', NULL);
        }
        if (parent::containsId($review->getId(), 'review')) {
            throw new DBException('The database already contains a comment with this id', NULL);
        }
        $gameId = $this->addGame($review->getGame);
        $query = 'INSERT INTO ' . $this->_revT . '(users_writer_id, game_id,';
        $query .= 'platforms_platform_id, review_title, review_score, review_txt,';
        $query .= 'review_video_url, review_created, is_user_review) ';
        $query .= $this->getReviewValuesString($review, $gameId);
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
        return parent::getLastId();
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

    public function addGalleryImage($reviewId, \Image $image) {
        
    }

    public function addGoodBadTag($reviewId, $goodBadTag) {
        
    }

    public function addRootComment($reviewId, \Comment $rootComment) {
        
    }

    public function addUserScore($reviewId, $userId, $userScore) {
        
    }

    public function getReviews($options) {
        
    }

    public function getUserReviewsForGame($gameId, $limit = -1) {
        
    }

    public function getUserReviewsForUser($userId, $limit = -1) {
        
    }

    public function removeGalleryImage($reviewId, $imageId) {
        
    }

    public function removeGoodBadTag($reviewId, $goodBadTagId) {
        
    }

    public function removeRootComment($reviewId, $commentId) {
        
    }

    public function removeUserScore($reviewId, $userId) {
        
    }

    public function udpateUserScore($reviewId, $userId, $newScore) {
        
    }

    public function updateGame($reviewId, \Game $game) {
        
    }

    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, \Image $headerImg) {
        
    }

    public function addVoter($objectId, $voterId, $notifId, $voteFlag) {
        
    }

    public function getVotedNotifId($objectId, $voteFlag) {
        
    }

    public function getVoters($objectId, $flag = -1, $limit = -1) {
        
    }

    public function getVotersCount($objectId, $flag) {
        
    }

    public function hasVoted($objectId, $userId) {
        
    }

    public function removeVoter($objectId, $voterId) {
        
    }

    public function updateVoter($objectId, $voterId, $voteFlag) {
        
    }

    public function updateVoterNotif($objectId, $voterId, $notifId) {
        
    }

    private function addGame(Game $game) {
        $gameId = $this->_reviewDistDB->addGame($game);
        return $gameId;
    }

    private function getReviewValuesString(Review $review, $gameId) {
        
    }

}
