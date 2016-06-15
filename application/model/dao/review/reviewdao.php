<?php

/**
 * ReviewDao
 * This is an interface for all classes that handle review database functionality
 * @package dao
 * @subpackage dao.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface ReviewDao extends VoteFunctionalityDao {

    /**
     * getReviews
     * Returns all reviews with these options.
     * possible options: 
     * -where: string platform, string genre, string gbt, string gameName, 
     *  stringtitle, string txt, boolean userReview
     * -having: int minScore, int maxScore
     * -order: string col, string order
     * -limit: int limit 
     * @param array $options      
     * @return Review[]
     */
    public function getReviews($options);

    /**
     * getUserReviewsForGame
     * Returns all reviews for this game, written by non-admin users.
     * Can be limited
     * @param int $gameId
     * @param int $limit
     * * @return Review[]
     */
    public function getUserReviewsForGame($gameId, $limit = -1);

    /**
     * getUserReviewsForUser
     * Returns all the reviews written by user with this id.
     * Can be limited
     * @param int $userId
     * @param int $limit
     * @return Review[]
     */
    public function getUserReviewsForUser($userId, $limit = -1);

    /**
     * getUserReviewForGameAndUser
     * Returns the user review for this game and this user is present.
     * Else returns -1
     * @param int $gameId
     * @param int $userId
     */
    public function getUserReviewForGameAndUser($gameId, $userId);

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
    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, $headerImg);

    /**
     * addUserScore
     * Adds a user score to the user scores
     * @param int $reviewId
     * @param int $userId
     * @param int $userScore
     */
    public function addUserScore($reviewId, $userId, $userScore);

    /**
     * userRatedReview
     * Checks if a user has already rated a review.
     * If the user did, return the score, else return -1
     * @param int $reviewId
     * @param int $userId
     * @return int
     */
    public function userRatedReview($reviewId, $userId);

    /**
     * getUserScores     
     * @param int $reviewId
     * @return array $userScores
     */
    public function getUserScores($reviewId);

    /**
     * updateUserScore
     * Updates the user score for this user and review combination
     * @param int $reviewId
     * @param int $userId
     * @param int $newScore
     */
    public function updateUserScore($reviewId, $userId, $newScore);

    /**
     * removeUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId);

    /**
     * addGood
     * Adds a good the database
     * @param int $reviewId
     * @param string $good    
     */
    public function addGood($reviewId, $good);

    /**
     * addBad
     * Adds a bad to the database
     * @param int $reviewId
     * @param string $bad     
     */
    public function addBad($reviewId, $bad);

    /**
     * addTag
     * Adds a tag to the database
     * @param int $reviewId
     * @param string $tag
     */
    public function addTag($reviewId, $tag);

    /**
     * getGoods
     * Returns all the good points for a review
     * @param int $reviewId
     * @return string[]
     */
    public function getGoods($reviewId);

    /**
     * getGoods
     * Returns all the good points for a review
     * @param int $reviewId
     * @return string[]
     */
    public function getBads($reviewId);

    /**
     * getGoods
     * Returns all the good points for a review
     * @param int $reviewId
     * @return string[]
     */
    public function getTags($reviewId);

    /**
     * removeGood
     * Removew a good from the database
     * @param int $reviewId
     * @param string $good
     * @throws DBException
     */
    public function removeGood($reviewId, $good);

    /**
     * removeBad
     * Removew a bad from the database
     * @param int $reviewId
     * @param string $bad
     * @throws DBException
     */
    public function removebad($reviewId, $bad);

    /**
     * removeTag
     * Removew a tag from the database
     * @param int $reviewId
     * @param string $tag
     * @throws DBException
     */
    public function removeTag($reviewId, $tag);

    /**
     * addHeaderImage
     * Adds the header image to this review
     * @param int $reviewId
     * @param Image $image
     */
    public function addHeaderImage($reviewId, Image $image);

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param Image $image
     */
    public function addGalleryImage($reviewId, Image $image);

    /**
     * getHeaderImage
     * Returns the header image for this review
     * @param itn $reviewId
     * @return Image $headerImage
     */
    public function getHeaderImage($reviewId);

    /**
     * getGallery
     * Returns the image gallery for this review
     * @param int $reviewId
     * @return Image[]
     */
    public function getGallery($reviewId);

    /**
     * updateHeaderImage
     * Updates the header image of this review
     * @param int $reviewId
     * @param Image $image
     */
    public function updateHeaderImage($reviewId, Image $image);

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function removeGalleryImage($reviewId, $imageId);

    /**
     * getGame
     * returns the game for this review
     * @param type $reviewId
     * @return Game
     */
    public function getGame($reviewId);

    /**
     * updateGame
     * Updates the game for this review
     * @param int $gameId
     * @param Game $game
     */
    public function updateGameCore($gameId, Game $game);

    /**
     * addRootComment
     * Adds a root comment to this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param Comment $rootComment
     */
    public function addRootComment($reviewId, Comment $rootComment);

    /**
     * getReviewRootcomments
     * Returns all root comments for the review with this id   
     * @param int $reviewId
     * @param int $limit
     * @return Comment[]
     * @throws DBException
     */
    public function getRootComments($reviewId, $limit = 100);

    /**
     * getCommentedNotification
     * Helper function to assist the remove function
     * Returns the id of the notification for commented on or -1 if none are found
     * @param int $reviewId
     * @return int $notifId
     */
    public function getCommentedNotification($reviewId);

    /**
     * updateRootCommentNotification
     * Updates the notification id for this review comment combination
     * @param int $reviewId
     * @param int $commentId
     * @param int $notifId
     */
    public function updateRootCommentNotification($reviewId, $commentId, $notifId);

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId);

    /**
     * getWriter
     * Returns the writer of this review
     * @param int $reviewId
     * @return UserSimple $writer
     */
    public function getWriter($reviewId);
}
