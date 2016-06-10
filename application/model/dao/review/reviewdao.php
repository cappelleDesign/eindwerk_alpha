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
     * possible options: int $limit, string $orderBy, string $order, int $minScore, 
     * int $maxScore, array $platforms, arrya $genres, array $tags
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
    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, Image $headerImg);

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
     * updateUserScore
     * Updates the user score for this user and review combination
     * @param int $reviewId
     * @param int $userId
     * @param int $newScore
     */
    public function udpateUserScore($reviewId, $userId, $newScore);

    /**
     * removeUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId);

    /**
     * addGoodBadTag
     * Adds a good, a bad or a tag to the database
     * @param int $reviewId
     * @param string $goodBadTag
     * @param string $type
     */
    public function addGoodBadTag($reviewId, $goodBadTag, $type);

    /**
     * removeGoodBadTag
     * Removew a good, a bad or a tag from the database
     * @param int $reviewId
     * @param int $goodBadTagId
     */
    public function removeGoodBadTag($reviewId, $goodBadTagId);

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param Image $image
     */
    public function addGalleryImage($reviewId, Image $image);

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function removeGalleryImage($reviewId, $imageId);

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
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId);
}
