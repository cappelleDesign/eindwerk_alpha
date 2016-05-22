<?php

interface CommentDao extends Dao {


    public function addVoter($commentId, $voterId, $notifId, $voteFlag);

    public function removeVoter($commentId, $voterId);

    public function updateVoter($commentId, $voterId, $voteFlag);

    public function updateCommentText($commentId, $text);
    
    public function updateCommentNotification($commentId, $notificationId);
    
    public function getSubComments($parentID, $limit, $group);

    public function getSubcommentsCount($parentID, $group);

//    public function getParentId($subId);
    
    public function getSuperParentId($commentId);

    public function getReviewRootComments($reviewId);

    public function getVideoRootComments($videoId);

    public function getVotedNotifId($commentId, $voteFlag);
        
}
