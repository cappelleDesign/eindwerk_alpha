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

//    public function addVoter($commentId, $voterId, $voterName, $voteFlag) {
//        try {
//            $flagPrev = $this->_commentDB->hasVoted($commentId, $voterId);
//            if ($flagPrev === -1) {
//                $notifId = $this->_notificationHandler->notifyParentWriterVoted('comment', $commentId, $voterId, $voterName, $voteFlag);
//                $this->_commentDB->addVoter($commentId, $voterId, $notifId, $voteFlag);
//            } else if ($flagPrev === $voteFlag) {
//                $this->removeVoter($commentId, $voterId, $voteFlag);
//            } else {
//                $this->updateVoter($commentId, $voterId, $voterName, $voteFlag, $flagPrev);
//            }
//        } catch (Exception $ex) {
//            throw new ServiceException($ex->getMessage(), $ex);
//        }
//    }
//
//    public function updateVoter($commentId, $voterId, $voterName, $voteFlag, $prevFlag) {
//        try {
//            $notifPrev = $this->_commentDB->getVotedNotifId($commentId, $prevFlag);
//            $notifId = $this->_notificationHandler->notifyParentWriterVoted('comment', $commentId, $voterId, $voterName, $voteFlag);
//            $this->_commentDB->updateVoter($commentId, $voterId, $voteFlag);
//            $this->_commentDB->updateVoterNotif($commentId, $voterId, $notifId);
//            $this->_notificationHandler->notifyParentWriterVoted('comment', $commentId, $voterId, -1, $prevFlag, $notifPrev);
//        } catch (Exception $ex) {
//            throw new ServiceException($ex->getMessage(), $ex);
//        }
//    }
//
//    public function removeVoter($commentId, $voterId, $voteFlag) {
//        try {
//            $notifPrev = $this->_commentDB->getVotedNotifId($commentId, $voteFlag);
//            $this->_commentDB->removeVoter($commentId, $voterId);
//
//            $this->_notificationHandler->notifyParentWriterVoted('comment', $commentId, $voterId, -1, $voteFlag, $notifPrev);
//        } catch (Exception $ex) {
//            throw new ServiceException($ex->getMessage(), $ex);
//        }
//    }
//
//    public function hasVoted($commentId, $userId) {
//        try {
//            return $this->_commentDB->hasVoted($commentId, $userId);
//        } catch (Exception $ex) {
//            throw new ServiceException($ex->getMessage(), $ex);
//        }
//    }

}
