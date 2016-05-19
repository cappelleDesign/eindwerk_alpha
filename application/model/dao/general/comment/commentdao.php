<?php

interface CommentDao extends Dao {

    public function updateCommentText($commentId, $text);

    public function addVoter($commentId, $voterId, $notifId, $voteFlag);

    public function removeVoter($commentId, $voterId);

    public function updateVoter($commentId, $voterId, $voteFlag);

    public function getSubComments($parentID, $limit);

    public function getSubcommentsCount($parentID);

//    public function getParentId($subId);

    public function getReviewRootComments($reviewId);

    public function getVideoRootComments($videoId);

    public function getVotedNotifId($commentId, $voteFlag);
}
