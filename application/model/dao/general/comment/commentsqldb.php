<?php

class CommentSqlDB extends SqlSuper implements CommentDao {

    /**
     * The comment table
     * @var string 
     */
    private $_commentT;

    /**
     * User sqldb to get users
     * @var UserSqlDB 
     */
    private $_userDB;

    public function __construct($connection, $userSqlDb) {
        parent::__construct($connection);
        $this->_userDB = $userSqlDb;
        $this->init();
    }

    private function init() {
        $this->_commentT = Globals::getTableName('comment');
    }

    public function add(DaoObject $comment) {
        if (!$comment instanceof Comment) {
            throw new DBException('The object you tried to add was not a comment object', NULL);
        }
        if (parent::containsId($comment->getId(), 'comment')) {
            throw new DBException('The database already contains a comment with this id', NULL);
        }
        $query = 'INSERT INTO ' . $this->_commentT . ' (`users_writer_id`, `parent_id`, `commented_on_notif_id`,`comment_txt`, `comment_created`)';
        $query.= 'VALUES (:users_writer_id, :parent_id, :commented_on_notif_id, :comment_txt, :comment_created)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':users_writer_id' => $comment->getPoster()->getId(),
            ':parent_id' => $comment->getParentId(),
            ':commented_on_notif_id' => $comment->getNotifId(),
            ':comment_txt' => $comment->getBody(),
            ':comment_created' => $comment->getCreatedStr(Globals::getDateTimeFormat('mysql', true))
        );
        $statement->execute($queryArgs);
    }

    public function get($id) {
        parent::triggerIdNotFound($id, 'comment');
        $query = 'SELECT * FROM ' . $this->_commentT . ' WHERE comment_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $row = $result[0];
        $poster = $this->_userDB->getSimple($row['users_writer_id']);
        $voters = $this->_userDB->getUserDistDB()->getVoters($row['comment_id']);
        $comment = parent::getCreationHelper()->createComment($row, $poster, $voters);
        return $comment;
    }

    public function getByString($identifier) {
        $query = 'SELECT comment_id FROM ' . $this->_commentT . ' WHERE comment_txt = :identifier';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(':identifier', $identifier);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        if (empty($result)) {
            throw new DBException('No comment with this body: ' . $identifier);
        }
        $row = $result[0];
        return $this->get($row['comment_id']);
    }

    public function remove($id) {
        parent::triggerIdNotFound($id, 'comment');
        $query = 'DELETE FROM ' . $this->_commentT . ' WHERE comment_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

    private function getNotifId($commentId, $voteFlag) {
        $query = 'SELECT * FROM ' . Globals::getTableName('comment_vote') . ' WHERE comment_id = :commentId AND vote_flag = :voteFlag';
        $statement = parent::prepareStatement($query);
        $queryArgs = array (
            ':commentId' => $commentId,
            ':voteFlag' => $voteFlag
        );
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        if(empty($result)) {
            return -1;
        } 
        $row = $result[0];
        return $row['voted_on_notif_id'];
        
    }
    
    private function getVoteText($voteFlag) {
        switch ($voteFlag) {
            case '1':
                return ' downvoted your comment :(';
            case '2' :
                return ' upvoted your comment!';
            case '3' :
                return ' gave your comment a diamond';
        }
    }
    
    public function addVoter($commentId, $voterId, $voterName,$voteFlag) {
        parent::triggerIdNotFound($commentId, 'comment');
        parent::triggerIdNotFound($voterId, 'user');
        $notifId = $this->getNotifId($commentId, $voteFlag);
        if($notifId < 0) {
//            $row['user_id'], $row['notification_txt'], $row['notification_date'], $row['notification_isread'], Globals::getDateTimeFormat('mysql', true)
            $notifRow = array(
                'user_id' => $voterId,
                'notification_txt' => $voterName . $this->getVoteText($voteFlag)
            );
            $notification = parent::getCreationHelper()->createNotification($notifRow);
            $this->_userDB->addNotification($userId, $notification);
        } else {
            
        }
//        $query = 'INSERT INTO ' . Globals::getTableName('comment_vote') . '(comment_id,users_voter_id,voted_on_notif_id,vote_flag)';
//        $statement = parent::prepareStatement($query);
//        $queryArgs = array(
//        );
//        $statement->execute($queryArgs);
    }

    public function removeVoter($commentId, $voterId) {
        parent::triggerIdNotFound($id, 'comment');
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
    }

    public function updateComment(Comment $comment) {
        $id = $comment->getId();
        parent::triggerIdNotFound($id, 'comment');
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
    }

    public function updateVoter($commentId, $voterId, $voteFlag) {
        parent::triggerIdNotFound($id, 'comment');
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
    }

    public function getParentId($subId) {
        parent::triggerIdNotFound($id, 'comment');
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
    }

    public function getSubComments($parentID) {
        parent::triggerIdNotFound($id, 'comment');
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
    }

    public function getReviewRootComments($reviewId) {
        
    }

    public function getVideoRootComments($videoId) {
        
    }

}
