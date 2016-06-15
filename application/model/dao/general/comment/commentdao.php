<?php

/**
 * ReviewDistDao
 * This is an interface for all classes that handle review dist database functionality
 * @package dao
 * @subpackage dao.general.comment
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface CommentDao extends VoteFunctionalityDao {

    /**
     * updateCommentText
     * Updates the comment body
     * @param int $commentId
     * @param string $text
     */
    public function updateCommentText($commentId, $text);

    /**
     * updateCommentNotification
     * Updates the notification id for this comment
     * @param int $commentId
     * @param int $notificationId
     */
    public function updateCommentNotification($commentId, $notificationId);

    /**
     * getSubComments
     * Returns the sub comments for this comment.
     * Can be limited by a number.
     * Can be grouped by the id so no double writers are returned
     * @param int $parentId
     * @param int $limit
     * @param boolean $group
     * @return Comment[]
     */
    public function getSubComments($parentId, $limit = 100, $group = FALSE);

    /**
     * getSubCommentsCount
     * Returns the number of sub comments.
     * Can be grouped so a writer is only counted once
     * @param int $parentId
     * @param boolean $group
     * @return int
     */
    public function getSubcommentsCount($parentId, $group);

    /**
     * getSuperParentId
     * Returns the id of the parent of a root comment.
     * This id can belong to a review
     * @param int $commentId
     * @return int
     */
    public function getSuperParentId($commentId);

    /**
     * getReviewRootcomments
     * Returns all root comments for the review with this id
     * @param int $reviewId
     * @return Comment[]
     * @throws DBException
     */
    public function getReviewRootComments($reviewId, $limit = 100, $group = FALSE);

    /**
     * DEPRECATED
     * getVideoRootComments
     * Returns all root comments for the video with this id
     * @param int $videoId
     * @return Comment[]
     * @throws DBException
     */
    public function getVideoRootComments($videoId);
}
