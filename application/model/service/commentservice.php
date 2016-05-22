<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of commentservice
 *
 * @author jens
 */
class CommentService {

    /**
     * The comment database
     * The type of database depends on the config file
     * @var CommentDao
     */
    private $_commentDB;

    /**
     * The user database.
     * The type of database depends on the config file
     * @var UserDao
     */
    private $_userDb;

    /**
     * The handler for notification related stuff
     * @var notificationHandler
     */
    private $_notificationHandler;

    public function __construct($commentDb, $userDb, $notificationHandler) {
        $this->init($commentDb, $userDb, $notificationHandler);
    }

    private function init($commentDb, $userDb, $notificationHandler) {
        $this->_commentDB = $commentDb;
        $this->_userDb = $userDb;
        $this->_notificationHandler = $notificationHandler;
    }

    public function addComment(Comment $comment) {
        try {
            $commentId = $this->_commentDB->add($comment);
            $comment->setId($commentId);
            $this->_notificationHandler->notifyParentWriter($comment);            
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }
    
    public function removeComment($commentId, $notifId) {
        try{
            //FIXME remove everything this comment is linked to and update the notification 
        } catch (Exception $ex) {

        }
    }

}
