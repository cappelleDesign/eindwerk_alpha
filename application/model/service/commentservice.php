<?php

class CommentService extends VoteService{

    /**
     * The comment database
     * The type of database depends on the config file
     * @var CommentDao
     */
    private $_commentDB;

    /**
     * The handler for notification related stuff
     * @var notificationHandler
     */
    private $_notificationHandler;

    public function __construct($commentDb, $notificationHandler) {
        $this->init($commentDb, $notificationHandler);
    }

    private function init($commentDb, $notificationHandler) {
        $this->_commentDB = $commentDb;
        $this->_notificationHandler = $notificationHandler;        
        parent::voteInit('comment', $this->_commentDB, $this->_notificationHandler);
    }

    /**
     * addComment
     * Adds a comment to the database
     * @param Comment $comment
     * @throws ServiceException
     */
    public function addComment(Comment $comment) {
        try {
            $commentId = $this->_commentDB->add($comment);
            $comment->setId($commentId);
            $this->_notificationHandler->notifyParentWriterCommented($comment);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getComment($commentId) {
        try {
            return $this->_commentDB->get($commentId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function updateCommentText($commentId, $text) {
        try {
            $this->_commentDB->updateCommentText($commentId, $text);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function removeComment($commentId) {
        try {
            $comment = $this->_commentDB->get($commentId);
            $this->_commentDB->startTransaction();
            $this->_commentDB->remove($commentId);
            $this->_commentDB->endTransaction();
            $this->_notificationHandler->notifyParentWriterCommented($comment);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getSubComments($parentId) {
        try {
            return $this->_commentDB->getSubComments($parentId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getCommentsForUser($options) {
        try {
            $userId = $options['userId'];
            $limit = $options['limit'];
            return $this->_commentDB->getCommentsForUser($userId, $limit);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(),$ex);
        }
    }
    
    public function getReviewRootComments($reviewId) {
        try {
            return $this->_commentDB->getReviewRootComments($reviewId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getVideoRootComments($videoId) {
        try {
            return $this->_commentDB->getVideoRootComments($videoId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    //obsolete?
    public function getVoters($commentId) {
        try {
            return $this->_commentDB->getVoters($commentId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getDownVotersCount($commentId) {
        try {
            return $this->_commentDB->getVotersCount($commentId, 1);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getUpVotersCount($commentId) {
        try {
            return $this->_commentDB->getVotersCount($commentId, 2);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    public function getDiamondVotersCount($commentId) {
        try {
            return $this->_commentDB->getVotersCount($commentId, 3);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }
}
