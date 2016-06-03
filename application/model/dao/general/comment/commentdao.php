<?php

interface CommentDao extends Dao {

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
     * This id can belong to a review or to a video
     * @param int $commentId
     * @return int
     */
    public function getSuperParentId($commentId);

    /**
     * getReviewRootcomments
     * Returns all root comments for the review with this id
     * 
     * START ORIGINAL SQL
      SELECT c.comment_id, c.users_writer_id, c.parent_id, c.parent_root_id, c.commented_on_notif_id, c.comment_txt, c.comment_created
      FROM
      comments c LEFT JOIN reviews_has_comments r
      ON c.comment_id = r.comments_comment_id
      WHERE r.reviews_review_id = 1
      ORDER BY c.comment_created DESC
     * END ORIGINAL SQL
     * 
     * @param int $reviewId
     * @return Review[]
     * @throws DBException
     */
    public function getReviewRootComments($reviewId);

    /**
     * getVideoRootComments
     * Returns all root comments for the video with this id
     * 
     * START ORIGINAL SQL
      SELECT c.comment_id, c.users_writer_id, c.parent_id, c.parent_root_id, c.commented_on_notif_id, c.comment_txt, c.comment_created
      FROM
      comments c LEFT JOIN video_has_comments v
      ON c.comment_id = v.comments_comment_id
      WHERE v.video_video_id = 1
      ORDER BY c.comment_created DESC
     * END ORIGINAL SQL
     * 
     * @param int $videoId
     * @return Review[]
     * @throws DBException
     */
    public function getVideoRootComments($videoId);

    /**
     * getVoters
     * Returns all voters for the given params 
     * @param int $commentId
     * @param int $flag (if -1, search all flags)
     * @param int $limit
     * @return Vote[]
     */
    public function getVoters($commentId, $flag = -1, $limit = -1);

    /**
     * getVotersCount
     * Returns the number of voters for this flag
     * @param int $commentId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($commentId, $flag);

    /**
     * addVoter
     * Adds a voter to a comment
     * @param int $commentId
     * @param int $voterId
     * @param int $notifId
     * @param int $voteFlag
     */
    public function addVoter($commentId, $voterId, $notifId, $voteFlag);

    /**
     * removeVoter
     * Removes a voter from this comment
     * @param int $commentId
     * @param int $voterId
     */
    public function removeVoter($commentId, $voterId);

    /**
     * updateVoter
     * Updates a vote for this comment
     * @param int $commentId
     * @param int $voterId
     * @param int $voteFlag
     */
    public function updateVoter($commentId, $voterId, $voteFlag);

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param int $commentId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($commentId, $voterId, $notifId);

    /**
     * getVotedNotifId
     * Get the id of the notification linked to this vote
     * @param int $commentId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($commentId, $voteFlag);

    /**
     * hasVoted
     * Returns if a user voted on this object.
     * Return value is the flag related to this vote or -1 if the user did 
     * not yet vote on this comment
     * @param string $objectName
     * @param int $objectId
     * @param int $userId
     * @return int
     */
    public function hasVoted($commentId, $userId);
}
