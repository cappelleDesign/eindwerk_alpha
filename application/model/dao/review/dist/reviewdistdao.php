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
     * getGoodsBasTags
     * Returns all the good/bad/tag points for a review
     * @param int $reviewId
     * @param string $type
     * @return string[]
     */
    public function getGoodsBadsTags($reviewId, $type);

    /**
     * searchGBT
     * Searches for a good, bad or tag by name and returns it's id if found,
     * -1 otherwise
     * @param int $revId
     * @param string $gbtText
     * @param string $type
     */
    public function searchGBT($revId, $gbtText, $type);

    /**
     * removeGoodBadTag
     * Removew a good, a bad or a tag from the database
     * @param int $reviewId
     * @param int $goodBadTagId
     * @param string $type
     */
    public function removeGoodBadTag($reviewId, $goodBadTagId, $type);

    /**
     * addHeaderImage
     * Adds the header image to this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function addHeaderImage($reviewId, $imageId);

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function addGalleryImage($reviewId, $imageId);

    /**
     * getHeaderImageId
     * Returns the header image id for this review
     * @param itn $reviewId
     * @return int $headerImageId
     */
    public function getHeaderImageId($reviewId);

    /**
     * getGalleryIds
     * Returns the image gallery id's for this review
     * @param int $reviewId
     * @return int[]
     */
    public function getGalleryIds($reviewId);

    /**
     * updateHeaderImage
     * Updates the header image of this review
     * @param type $reviewId
     * @param int $imageId
     */
    public function updateHeaderImage($reviewId, $imageId);

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
     */
    public function addRootComment($reviewId, $commentId);

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
}
