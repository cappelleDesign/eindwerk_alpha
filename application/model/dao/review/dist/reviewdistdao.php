<?php

/**
 * ReviewDistDao
 * This is an interface for all classes that handle review dist database functionality
 * @package dao
 * @subpackage dao.review.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface ReviewDistDao {

    /**
     * AddUserScore
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
    public function updateUserScore($reviewId, $userId, $newScore);

    /**
     * RemoveUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId);

    /**
     * addGoodBadTag
     * Adds a good, a bad or a tag to the database
     * @param int $reviewId
     * @param int $goodBadTag
     * @param string $type
     */
    public function addGoodBadTag($reviewId, $goodBadTag, $type);

    /**
     * addGoodBadTagsFull     
     * Adds all goods, bads or tags from an array to the database
     * @param int $revId
     * @param string[] $arr
     * @param string $type
     */
    public function addGoodBadTagsFull($revId, $arr, $type);

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
     * addRootComment
     * Adds a root comment to this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int commentId
     * @param Comment $rootComment
     */
    public function addRootComment($reviewId, $commentId, Comment $rootComment);

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId);

    /**
     * addVoter
     * Adds a voter to a VoteFunctionalityObject
     * @param int $reviewId
     * @param int $voterId
     * @param int $notifId
     * @param int $voteFlag
     */
    public function addVoter($reviewId, $voterId, $notifId,$voteFlag);

    /**
     * getVotedNotifId
     * Get the id of the notification linked to this vote
     * @param int $objectId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($objectId, $voteFlag);

    /**
     * getVoters
     * Returns all voters for the given params 
     * @param int $objectId
     * @param int $flag (if -1, search all flags)
     * @param int $limit
     * @return Vote[]
     */
    public function getVoters($objectId, $flag = -1, $limit = -1);

    /**
     * getVotersCount
     * Returns the number of voters for this flag
     * @param int $objectId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($objectId, $flag);

    /**
     * hasVoted
     * Returns if a user voted on this Review.
     * Return value is the flag related to this vote or -1 if the user did 
     * not yet vote on this Review     
     * @param int $objectId
     * @param int $userId
     * @return int
     */
    public function hasVoted($objectId, $userId);

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($objectId, $voterId, $notifId);

    /**
     * updateVoter
     * Updates a voter for this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function updateVoter($reviewId, $voterId, $voterFlag);

    /**
     * removeVoter
     * Removes a voter from this review
     * @param int $reviewId
     * @param int $voterId
     */
    public function removeVoter($reviewId, $voterId);
}
