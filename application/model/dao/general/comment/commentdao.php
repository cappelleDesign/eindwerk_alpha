<?php

interface CommentDao extends Dao {
    
    public function updateComment(Comment $comment);    
    
    public function addVoter($commentId, $voterId, $voterName, $voteFlag);
    
    public function removeVoter($commentId, $voterId);
    
    public function updateVoter($commentId, $voterId, $voteFlag);
    
    public function getSubComments($parentID);
    
    public function getParentId($subId);
    
    public function getReviewRootComments($reviewId);
    
    public function getVideoRootComments($videoId);
}
