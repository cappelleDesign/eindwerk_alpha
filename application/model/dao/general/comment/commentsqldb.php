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

    /**
     * Vote sqldb to handle vote related functions
     * @var VoteSqlDB
     */
    private $_voteDB;

    public function __construct($connection, $userSqlDb, $voteSqlDb) {
        parent::__construct($connection);
        $this->_userDB = $userSqlDb;
        $this->_voteDB = $voteSqlDb;
        $this->init();
    }

    private function init() {
        $this->_commentT = Globals::getTableName('comment');
    }

    /**
     * add
     * Adds a comment to the database
     * @param Comment $comment
     * @return int the id of the added comment
     * @throws DBException
     */
    public function add(DaoObject $comment) {
        if (!$comment instanceof Comment) {
            throw new DBException('The object you tried to add was not a comment object', NULL);
        }
        if (parent::containsId($comment->getId(), 'comment')) {
            throw new DBException('The database already contains a comment with this id', NULL);
        }
        $query = 'INSERT INTO ' . $this->_commentT . ' (`users_writer_id`, `parent_id`, parent_root_id,`commented_on_notif_id`,`comment_txt`, `comment_created`)';
        $query.= 'VALUES (:users_writer_id, :parent_id, :parent_root_id,:commented_on_notif_id, :comment_txt, :comment_created)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':users_writer_id' => $comment->getPoster()->getId(),
            ':parent_id' => $comment->getParentId(),
            ':parent_root_id' => $comment->getParentRootId(),
            ':commented_on_notif_id' => $comment->getNotifId(),
            ':comment_txt' => $comment->getBody(),
            ':comment_created' => $comment->getCreatedStr(Globals::getDateTimeFormat('mysql', true))
        );
        $statement->execute($queryArgs);
        return parent::getLastId();
    }

    /**
     * get
     * Returns the comment with this id
     * @param int $id
     * @return Comment
     */
    public function get($id) {
        parent::triggerIdNotFound($id, 'comment');
        $query = 'SELECT * FROM ' . $this->_commentT . ' WHERE comment_id=?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        $row = $result[0];
        $poster = $this->_userDB->getSimple($row['users_writer_id']);
        $voters = $this->getVoters($row['comment_id']);
        $comment = parent::getCreationHelper()->createComment($row, $poster, $voters);
        return $comment;
    }

    /**
     * getByString
     * Returns the comment with this text
     * @param string $identifier the body of the comment that is searched
     * @return Comment
     */
    public function getByString($identifier) {
        $query = 'SELECT comment_id FROM ' . $this->_commentT . ' WHERE comment_txt = :identifier';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(':identifier', $identifier);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        if (empty($result)) {
            throw new DBException('No comment with this body: ' . $identifier);
        }
        $row = $result[0];
        return $this->get($row['comment_id']);
    }

    /**
     * remove
     * Removes the comment with this id from the database
     * @param int $id
     */
    public function remove($id) {
        parent::triggerIdNotFound($id, 'comment');

        $notifId1 = $this->getVotedNotifId($id, 1);
        $notifId2 = $this->getVotedNotifId($id, 2);
        $notifId3 = $this->getVotedNotifId($id, 3);
        $commentedNotifId = $this->getCommentedOnNotif($id);

        $this->removeRelatedVotes($id);
        $this->removeSubComments($id);
        $query = 'DELETE FROM ' . $this->_commentT . ' WHERE comment_id=?;';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();

        $this->removeNotifications($notifId1);
        $this->removeNotifications($notifId2);
        $this->removeNotifications($notifId3);
        $this->removeNotifications($commentedNotifId);
    }

    /**
     * removeSubComments
     * Helper function for remove. 
     * Removes all the sub comments for this comment
     * @param int $commentId
     */
    private function removeSubComments($commentId) {
        $query = 'SELECT comment_id FROM ' . $this->_commentT . ' WHERE parent_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $commentId);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        foreach ($result as $row) {
            $this->remove($row['comment_id']);
        }
    }

    /**
     * removeRelatedVotes
     * Helper function for remove. 
     * Removes all the votes for this comment
     * @param int $commentId
     */
    private function removeRelatedVotes($commentId) {
        $query = 'DELETE FROM ' . Globals::getTableName('comment_vote') . ' WHERE comment_id=?;';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $commentId);
        $statement->execute();
    }

    /**
     * removeNotifications
     * Removes notifications related to a comment
     * @param int $notifId
     */
    private function removeNotifications($notifId) {
        if ($notifId && $notifId != -1) {
            $query = 'DELETE FROM ' . Globals::getTableName('notification') . ' WHERE notification_id=?';
            $statement = parent::prepareStatement($query);
            $statement->bindParam(1, $notifId);
            $statement->execute();
        }
    }

    /**
     * getCommentedOnNotif
     * Returns the notification id if this comment was commented on
     * @param int $commentId
     * @return int or NULL if not found
     */
    private function getCommentedOnNotif($commentId) {
        $query = 'SELECT commented_on_notif_id FROM ' . $this->_commentT . ' WHERE comment_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $commentId);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        $notifId = NULL;
        if (!empty($result)) {
            $notifId = $result[0]['commented_on_notif_id'];
        }
        return $notifId;
    }

    /**
     * updateCommentText
     * Updates the comment body
     * @param int $commentId
     * @param string $text
     */
    public function updateCommentText($commentId, $text) {
        parent::triggerIdNotFound($commentId, 'comment');
        $query = 'UPDATE ' . $this->_commentT . ' SET comment_txt = :text WHERE comment_id = :commentId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':text' => $text,
            ':commentId' => $commentId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateCommentNotification
     * Updates the notification id for this comment
     * @param int $commentId
     * @param int $notificationId
     */
    public function updateCommentNotification($commentId, $notificationId) {
        parent::triggerIdNotFound($commentId, 'comment');
        $query = 'UPDATE ' . $this->_commentT . ' SET commented_on_notif_id = :notifId WHERE comment_id = :commentId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':notifId' => $notificationId,
            ':commentId' => $commentId
        );
        $statement->execute($queryArgs);
    }

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
    public function getSubComments($parentId, $limit = 100, $group = FALSE) {
        parent::triggerIdNotFound($parentId, 'comment');
        $idCol = 'parent_id';
        $groupBy = '';
        if ($group) {
            $groupBy = ' GROUP BY users_writer_id ';
        }
        $query = 'SELECT * FROM ' . $this->_commentT . ' WHERE ' . $idCol . '= ?' . $groupBy . ' ORDER BY comment_created DESC LIMIT ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $parentId);
        $statement->bindParam(2, $limit, PDO::PARAM_INT);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);

        $subComments = array();
        foreach ($result as $row) {
            $poster = $this->_userDB->getSimple($row['users_writer_id']);
            $voters = $this->getVoters($row['comment_id']);
            $comment = parent::getCreationHelper()->createComment($row, $poster, $voters);
            array_push($subComments, $comment);
        }
        return $subComments;
    }

    /**
     * getSubCommentsCount
     * Returns the number of sub comments.
     * Can be grouped so a writer is only counted once
     * @param int $parentId
     * @param boolean $group
     * @return int
     */
    public function getSubCommentsCount($parentId, $group) {
        parent::triggerIdNotFound($parentId, 'comment');
        $count = '*';
        if ($group) {
            $count = 'DISTINCT users_writer_id';
        }
        $idCol = 'parent_id';
        $query = 'SELECT COUNT(' . $count . ') as count FROM ' . $this->_commentT . ' WHERE ' . $idCol . '= ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $parentId);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        return $result[0]['count'];
    }

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
    public function getReviewRootComments($reviewId) {
        //FIXME getRootComments($objectname, $objectId,..)
        parent::triggerIdNotFound($reviewId, 'review');
        $query = 'SELECT c.comment_id, c.users_writer_id, c.parent_id, c.parent_root_id, c.commented_on_notif_id, c.comment_txt, c.comment_created ';
        $query .= 'FROM ' . $this->_commentT . ' c LEFT JOIN ' . Globals::getTableName('review_comment') . ' r ';
        $query .= 'ON c.comment_id = r.comments_comment_id ';
        $query .= 'WHERE r.reviews_review_id = ? ';
        $query .= 'ORDER BY c.comment_created DESC';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        if (!empty($result)) {
            $comments = array();
            foreach ($result as $row) {
                $poster = $this->_userDB->getSimple($row['users_writer_id']);
                $voters = $this->getVoters($row['comment_id']);
                $comment = parent::getCreationHelper()->createComment($row, $poster, $voters);
                array_push($comments, $comment);
            }
            return $comments;
        } else {
            return NULL;
        }
    }

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
    public function getVideoRootComments($videoId) {
        //FIXME getRootComments($objectname, $objectId,..)
        parent::triggerIdNotFound($videoId, 'video');
        $query = 'SELECT c.comment_id, c.users_writer_id, c.parent_id, c.parent_root_id, c.commented_on_notif_id, c.comment_txt, c.comment_created ';
        $query .= 'FROM ' . $this->_commentT . ' c LEFT JOIN ' . Globals::getTableName('video_comment') . ' v ';
        $query .= 'ON c.comment_id = v.comments_comment_id ';
        $query .= 'WHERE v.video_video_id = ? ';
        $query .= 'ORDER BY c.comment_created DESC';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $videoId);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        if (!empty($result)) {
            $comments = array();
            foreach ($result as $row) {
                $poster = $this->_userDB->getSimple($row['users_writer_id']);
                $voters = $this->getVoters($row['comment_id']);
                $comment = parent::getCreationHelper()->createComment($row, $poster, $voters);
                array_push($comments, $comment);
            }
            return $comments;
        } else {
            return NULL;
        }
    }

    /**
     * getSuperParentId
     * Returns the id of the parent of a root comment.
     * This id can belong to a review or to a video
     * @param int $commentId
     * @return int
     */
    public function getSuperParentId($commentId) {
        $rev = $this->searchSuperParent('review', 'reviews_review_id', $commentId);
        if ($rev > -1) {
            return $rev;
        } else {
            $vid = $this->searchSuperParent('video', 'video_video_id', $commentId);
            if ($vid > -1) {
                return $vid;
            } else {
                return -1;
            }
        }
    }

    /**
     * searchSuperParent
     * Helperfunction for getSuperParentId
     * returns the id of the super parent searching for the specific parent type (review or video)
     * @param string $objectName
     * @param string $objectIdName
     * @param int $commentId
     * @return DaoObject review/video or -1 if not founc
     */
    private function searchSuperParent($objectName, $objectIdName, $commentId) {
        $query = 'SELECT ' . $objectIdName . ' FROM ' . Globals::getTableName($objectName . '_comment') . ' WHERE comments_comment_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $commentId);
        $statement->execute();        
        $result = parent::fetch($statement, TRUE);
        if (empty($result)) {
            return -1;
        } else {
            return $result[0][$objectIdName];
        }
    }

    /* ----------------------------------Vote---------------------------------- */

    /**
     * getVoters
     * Returns all voters for the given params 
     * @param int $commentId
     * @param int $flag (if -1, search all flags)
     * @param int $limit
     * @return Vote[]
     */
    public function getVoters($commentId, $flag = -1, $limit = -1) {
        return $this->_voteDB->getVoters('comment', $commentId, $flag, $limit);
    }

    /**
     * getVotersCount
     * Returns the number of voters for this flag
     * @param int $commentId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($commentId, $flag) {
        return $this->_voteDB->getVotersCount('comment', $commentId, $flag);
    }

    /**
     * addVoter
     * Adds a voter to a comment
     * @param int $commentId
     * @param int $voterId
     * @param int $notifId
     * @param int $voteFlag
     */
    public function addVoter($commentId, $voterId, $notifId, $voteFlag) {
        $this->_voteDB->addVoter('comment', $commentId, $voterId, $notifId, $voteFlag);
    }

    /**
     * updateVoter
     * Updates a vote for this comment
     * @param int $commentId
     * @param int $voterId
     * @param int $voteFlag
     */
    public function updateVoter($commentId, $voterId, $voteFlag) {
        $this->_voteDB->updateVoter('comment', $commentId, $voterId, $voteFlag);
    }

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param int $commentId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($commentId, $voterId, $notifId) {
        $this->_voteDB->updateVoterNotif('comment', $commentId, $voterId, $notifId);
    }

    /**
     * removeVoter
     * Removes a voter from this comment
     * @param int $commentId
     * @param int $voterId
     */
    public function removeVoter($commentId, $voterId) {
        $this->_voteDB->removeVoter('comment', $commentId, $voterId);
    }

    /**
     * getVotedNotifId
     * Get the id of the notification linked to this vote
     * @param int $commentId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($commentId, $voteFlag) {
        return $this->_voteDB->getVotedNotifId('comment', $commentId, $voteFlag);
    }

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
    public function hasVoted($commentId, $userId) {
        return $this->_voteDB->hasVoted('comment', $commentId, $userId);
    }

}
