<?php

class CommentSqlDB extends SqlSuper implements CommentDao {

    public function __construct($connection) {
        parent::__construct($connection);
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
        $commentT = Globals::getTableName('comment');
        $query = 'INSERT INTO ' . $commentT .' (`users_writer_id`, `parent_id`, `commented_on_notif_id`,`comment_txt`, `comment_created`)';
        $query.= 'VALUES (:users_writer_id, :parent_id, :commented_on_notif_id, :comment_txt, :comment_created)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array (
            ':users_writer_id' => $comment->getPoster()->getId(),
            ':parent_id' => $comment->getParentId(),
            ':commented_on_notif_id' => $comment->getNotifId(),
            ':comment_txt' => $comment->getBody(),
            ':comment_created' =>$comment->getCreatedStr(Globals::getDateTimeFormat('mysql', true))
        );
        $statement->execute($queryArgs);
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
