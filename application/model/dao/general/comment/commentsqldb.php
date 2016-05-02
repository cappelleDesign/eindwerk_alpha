<?php

class CommentSqlDB extends SqlSuper implements CommentDao {

    public function __construct($host, $username, $passwd, $database) {
        parent::__construct('mysql:host=' . $host, $username, $passwd, $database);
        $this->init();
    }

    private function init() {
        
    }

    public function add(DaoObject $comment) {
        if(!$comment instanceof Comment) {
          throw new DBException('The object you tried to add was not a comment object', NULL);
        }
        if (parent::containsId($comment->getId(), 'comment')) {
            throw new DBException('The database already contains a comment with this id', NULL);
        }
        $commentT = '';
        $query = '';
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

    public function addVoter($commentId, $voterId, $voterName, $voterFlag) {
        
    }

    public function removeVoter($commentId, $voterId) {
        
    }

    public function updateComment(Comment $comment) {
        
    }

    public function updateVoter($commentId, $voterId, $voteFlag) {
        
    }

}
