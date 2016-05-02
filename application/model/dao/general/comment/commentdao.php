<?php

interface CommentDao extends Dao {
    
    public function updateComment(Comment $comment);    
    
    public function addVoter($commentId, $voterId, $voterName, $voterFlag);
    
    public function removeVoter($commentId, $voterId);
    
    public function updateVoter($commentId, $voterId, $voteFlag);
}
