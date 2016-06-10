<?php

/**
 * ReviewSqlDB
 * This is a class that handles review SQL database functions
 * @package dao
 * @subpackage dao.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewSqlDB extends SqlSuper implements ReviewDao {

    /**
     * The review dist database
     * @var ReviewDistDao 
     */
    private $_reviewDistDB;

    /**
     * The comment database
     * @var CommentDao
     */
    private $_commentDB;

    /**
     * The general dist database
     * @var GeneralDistDao
     */
    private $_genDistDB;

    /**
     * The game database
     * @var GameDao
     */
    private $_gameDB;

    /**
     * The review table
     * @var string
     */
    private $_revT;

    public function __construct($connection, $commentDb, $genDistDb, $gameDB, $reviewDistDB) {
        parent::__construct($connection);
        $this->init($commentDb, $genDistDb, $gameDB, $reviewDistDB);
    }

    private function init($commentDb, $genDistDb, $gameDB, $reviewDistDB) {
        $this->_commentDB = $commentDb;
        $this->_genDistDB = $genDistDb;
        $this->_reviewDistDB = $reviewDistDB;
        $this->_gameDB = $gameDB;
        $this->_revT = Globals::getTableName('review');
    }

    /**
     * add
     * Adds a review to the database
     * @param Review $review
     * @return int $id
     * @throws DBException
     */
    public function add(DaoObject $review) {
        if (!$review instanceof Review) {
            throw new DBException('The object you tried to add was not a review object', NULL);
        }
        if ($this->getByString($review->getTitle())) {
            throw new DBException('The database already contains a review with this title');
        }
        if ($this->_gameDB->getByString($review->getGame()->getName())) {
            throw new DBException('The database already contains a review for this game');
        }
        $gameId = $this->addGame($review->getGame());
        $query = 'INSERT INTO ' . $this->_revT . '(users_writer_id, game_id,';
        $query .= 'platforms_platform_id, review_title, review_score, review_txt,';
        $query .= 'review_video_url, review_created, is_user_review) ';
        $query .= $this->getReviewValuesString($review, $gameId);
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
        foreach ($review->getGoods() as $good) {
            
        }
        foreach ($review->getBads() as $bad) {
            
        }
        foreach ($review->getTags() as $tag) {
            
        }
        return parent::getLastId();
    }

    /**
     * get
     * Returns a Review from the database if the id matches
     * @param int $id
     * @return Review
     * @throws DBException
     */
    public function get($id) {
        return NULL;
//        TODO implement
    }

    /**
     * getByString
     * Returns a Review from the database if the title matches
     * @param string $identifier
     * @return Review
     * @throws DBException
     */
    public function getByString($identifier) {
        return NULL;
//        TODO implement
    }

    /**
     * remove
     * Removes the game with this id from the database
     * @param int $id     
     */
    public function remove($id) {
        return NULL;
//        TODO implement
    }

    /**
     * getReviews
     * Returns all reviews with these options.
     * possible options: int $limit, string $orderBy, string $order, int $minScore, 
     * int $maxScore, array $platforms, arrya $genres, array $tags
     * @param array $options      
     * @return Review[]
     */
    public function getReviews($options) {
        return NULL;
//        TODO implement
    }

    /**
     * getUserReviewsForGame
     * Returns all reviews for this game, written by non-admin users.
     * Can be limited
     * @param int $gameId
     * @param int $limit
     * * @return Review[]
     */
    public function getUserReviewsForGame($gameId, $limit = -1) {
        return NULL;
//        TODO implement
    }

    /**
     * getUserReviewsForUser
     * Returns all the reviews written by user with this id.
     * Can be limited
     * @param int $userId
     * @param int $limit
     * @return Review[]
     */
    public function getUserReviewsForUser($userId, $limit = -1) {
        return NULL;
//        TODO implement
    }

    /**
     * updateReviewCore
     * Updates a review withoud updating the characteristics of the related game
     * @param int $reviewId
     * @param string $reviewedOn
     * @param string $title
     * @param int $score
     * @param string $text
     * @param string $videoUrl
     * @param Image $headerImg
     */
    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, Image $headerImg) {
        return NULL;
//        TODO implement
    }

    /**
     * updateGame
     * Updates the game for this review
     * @param int $gameId
     * @param Game $game
     */
    public function updateGameCore($gameId, Game $game) {
        $this->_gameDB->updateGameCore($gameId, $game);
    }

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param Image $image
     * @return int $imageId
     */
    public function addGalleryImage($reviewId, Image $image) {
        return $this->_reviewDistDB->addGalleryImage($reviewId, $image);
    }

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function removeGalleryImage($reviewId, $imageId) {
        $this->_reviewDistDB->removeGalleryImage($reviewId, $imageId);
    }

    /**
     * addGoodBadTag
     * Adds a good, a bad or a tag to the database
     * @param int $reviewId
     * @param int $goodBadTag
     * @param string $type
     * @return int $goodBadTagId
     */
    public function addGoodBadTag($reviewId, $goodBadTag, $type) {
        return $this->_reviewDistDB->addGoodBadTag($reviewId, $goodBadTag, $type);
    }

    /**
     * removeGoodBadTag
     * Removew a good, a bad or a tag from the database
     * @param int $reviewId
     * @param int $goodBadTagId
     */
    public function removeGoodBadTag($reviewId, $goodBadTagId) {
        $this->_reviewDistDB->removeGoodBadTag($reviewId, $goodBadTagId);
    }

    /**
     * addRootComment
     * Adds a root comment to this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int commentId
     * @param Comment $rootComment
     */
    public function addRootComment($reviewId, Comment $rootComment) {
        $commentId = $this->_commentDB->add($rootComment);
        $this->_reviewDistDB->addRootComment($reviewId, $commentId, $rootComment);
    }

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId) {
        $this->_commentDB->remove($commentId);
        $this->_reviewDistDB->removeRootComment($reviewId, $commentId);
    }

    /**
     * AddUserScore
     * Adds a user score to the user scores
     * @param int $reviewId
     * @param int $userId
     * @param int $userScore
     */
    public function addUserScore($reviewId, $userId, $userScore) {
        $this->_reviewDistDB->addUserScore($reviewId, $userId, $userScore);
    }

    /**
     * userRatedReview
     * Checks if a user has already rated a review.
     * If the user did, return the score, else return -1
     * @param int $reviewId
     * @param int $userId
     * @return int
     */
    public function userRatedReview($reviewId, $userId) {
        return $this->_reviewDistDB->userRatedReview($reviewId, $userId);
    }
    
    /**
     * updateUserScore
     * Updates the user score for this user and review combination
     * @param int $reviewId
     * @param int $userId
     * @param int $newScore
     */
    public function udpateUserScore($reviewId, $userId, $newScore) {
        $this->_reviewDistDB->updateUserScore($reviewId, $userId, $newScore);
    }

    /**
     * RemoveUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId) {
        $this->_reviewDistDB->removeUserScore($reviewId, $userId);
    }

    /**
     * addVoter
     * Adds a voter to this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function addVoter($reviewId, $voterId, $notifId, $voteFlag) {
        $this->_reviewDistDB->addVoter($reviewId, $voterId, $notifId, $voteFlag);
    }

    /**
     * getVotedNotifId
     * Get the id of the notification linked to this vote
     * @param int $objectId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($objectId, $voteFlag) {
        return $this->_reviewDistDB->getVotedNotifId($objectId, $voteFlag);
    }

    /**
     * getVoters
     * Returns all voters for the given params 
     * @param int $objectId
     * @param int $flag (if -1, search all flags)
     * @param int $limit
     * @return Vote[]
     */
    public function getVoters($objectId, $flag = -1, $limit = -1) {
        return $this->_reviewDistDB->getVoters($objectId, $flag, $limit);
    }

    /**
     * getVotersCount
     * Returns the number of voters for this flag
     * @param int $objectId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($objectId, $flag) {
        return $this->_reviewDistDB->getVotersCount($objectId, $flag);
    }

    /**
     * hasVoted
     * Returns if a user voted on this Review.
     * Return value is the flag related to this vote or -1 if the user did 
     * not yet vote on this Review     
     * @param int $objectId
     * @param int $userId
     * @return int
     */
    public function hasVoted($objectId, $userId) {
        return $this->_reviewDistDB->hasVoted($objectId, $userId);
    }

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($objectId, $voterId, $notifId) {
        $this->_reviewDistDB->updateVoterNotif($objectId, $voterId, $notifId);
    }

    /**
     * updateVoter
     * Updates a voter for this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function updateVoter($reviewId, $voterId, $voterFlag) {
        $this->_reviewDistDB->updateVoter($reviewId, $voterId, $voterFlag);
    }

    /**
     * removeVoter
     * Removes a voter from this review
     * @param int $reviewId
     * @param int $voterId
     */
    public function removeVoter($reviewId, $voterId) {
        $this->_reviewDistDB->removeVoter($reviewId, $voterId);
    }

    /**
     * addGame
     * Adds a game to the database
     * @param Game $game
     * @return int $gameId
     */
    private function addGame(Game $game) {
        $gameId = $this->_reviewDistDB->addGame($game);
        return $gameId;
    }

    /**
     * getReviewValuesString
     * Helper function to build the values string for the add query
     * @param Review $review
     * @param int $gameId
     * @return string $valuesString
     */
    private function getReviewValuesString(Review $review, $gameId) {
        
    }

    /**
     * addGoodBadTagsFull     
     * Adds all goods, bads or tags from an array to the database
     * @param int $revId
     * @param string[] $arr
     * @param string $type
     */
    private function addGoodBadTagsFull($revId, $arr, $type) {
        $this->_reviewDistDB->addGoodBadTagsFull($revId, $arr, $type);
    }

}
