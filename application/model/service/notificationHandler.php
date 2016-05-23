<?php

class notificationHandler {

    /**
     * The user database handler
     * @var UserDao 
     */
    private $_userDb;

    /**
     * The comment database handler
     * @var CommentDao 
     */
    private $_commentDb;

    /**
     * The review database handler
     * @var ReviewsDao 
     */
    private $_reviewDb;

    public function __construct(UserDao $userDb, CommentDao $commentDb, ReviewsDao $reviewDb) {
        $this->init($userDb, $commentDb, $reviewDb);
    }

    private function init($userDb, $commentDb, $reviewDb) {
        $this->_userDb = $userDb;
        $this->_commentDb = $commentDb;
        $this->_reviewDb = $reviewDb;
    }

    /**
     * notifyParents
     * Notifies the direct parent of this comment and the rootparent if necessary
     * @param Comment $comment
     */
    public function notifyParentWriterCommented($comment) {
        $txt = 'replied to your comment';
        if ($comment->getParentId()) {
            $parent = $this->_commentDb->get($comment->getParentId());
            if ($parent->getNotifId()) {
                $body = $this->buildNotificationBody($comment->getParentId(), $txt);
                $this->_userDb->updateNotification($parent->getNotifId(), $body, FALSE);
            } else {
                $body = $comment->getPoster()->getUsername() . ' ' . $txt;
                $notif = $this->createNotif($comment->getId(), $parent->getPoster()->getId(), $body);
                $notifId = $this->_userDb->addNotification($parent->getPoster()->getId(), $notif);
                $this->_commentDb->updateCommentNotification($comment->getParentId(), $notifId);
            }
        } else {
            $txt = 'commented on your ';
            $parent = $this->_commentDb->getSuperParentId($comment->getId());
            //TODO notify review writer if user review when review db is ready
        }
    }

    public function notifyParentWriterVoted($commentId, $voterId, $voterName, $voteFlag) {
        $notifId = $this->_commentDb->getVotedNotifId($commentId, $voteFlag);
        if ($notifId < 0) {
            $body = $voterName . $this->getVoteText($voteFlag);
            $notification = $this->createNotif($commentId, $voterId, $body);
            $this->_userDb->addNotification($voterId, $notification);
        } else {
            
        }
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

    /**
     * buildNotificationBody
     * Creates the correct body for comment related notification
     * @param int $subsForId     
     * @param string $text
     */
    private function buildNotificationBody($subsForId, $text) {
        $lastComments = $this->_commentDb->getSubComments($subsForId, 3, true);
        $count = $this->_commentDb->getSubCommentsCount($subsForId, true);
        $body = $lastComments[0]->getPoster()->getUsername();
        if ($count > 3) {
            $body .= ', ' . $lastComments[1]->getPoster()->getUsername();
            $body .= ', ' . $lastComments[2]->getPoster()->getUsername();
            $body .= ' and ' . ($count - 3) . ' other(s)';
        } else {
            if ($count > 2) {
                $body .= ', ' . $lastComments[1]->getPoster()->getUsername() . ' and ' . ($count - 2) . ' other(s)';
            } else if ($count > 1) {
                $body .= ' and ' . $lastComments[1]->getPoster()->getUsername();
            }
        }
        $body .= ' ' . $text;
        return $body;
    }

    private function createNotif($commentId, $userId, $body) {
        $linkBase = 'index.php/comments/show-comment/';
        $format = Globals::getDateTimeFormat('mysql', true);
        $date = DateFormatter::getNow()->format($format);
        $notif = new Notification($userId, $body, $linkBase . $commentId, $date, FALSE, $format);
        return $notif;
    }

}
