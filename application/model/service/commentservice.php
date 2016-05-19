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
     * notifyParents
     * Notifies the direct parent of this comment and the rootparent if necessary
     * @param Comment $comment
     */
    private function notifyParents($comment) {
        $txt = 'replied to your comment';
        if ($comment->getParentId()) {
            $parent = $this->get($comment->getParentId());
            if ($parent->getNotifId()) {
                $body = $this->buildNotificationBody($comment->getParentId(), $txt);
                Globals::cleanDump($body);
            } else {
                $body = $comment->getPoster()->getUsername() . ' ' . $txt;
                $notif = $this->createNotif($comment->getId(), $parent->getPoster()->getId(), $body);

                $this->_userDB->addNotification($parent->getPoster()->getId(), $notif);
                $notifId = parent::getLastId();
                Globals::cleanDump($notifId);
            }
        }
    }

    private function notifyWriter($commentId, $voterId, $voterName, $voteFlag) {
        $notifId = $this->getVotedNotifId($commentId, $voteFlag);
        if ($notifId < 0) {
            $notifRow = array(
                'user_id' => $voterId,
                'notification_txt' => $voterName . $this->getVoteText($voteFlag),
            );

            $notification = $this->createNotif($commentId, $voterId, $body);
            $this->_userDB->addNotification($voterId, $notification);
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
     * @param int $subForId     
     * @param string $text
     */
    private function buildNotificationBody($subsForId, $text) {
        $lastComments = $this->getSubComments($subsForId, 3);
        $count = $this->getSubCommentsCount($subsForId);
        $body = $lastComments[0]->getPoster()->getUsername();
        if ($count > 3) {
            $body .= ', ' . $lastComments[1]->getPoster()->getUsername();
            $body .= ', ' . $lastComments[2]->getPoster()->getUsername();
            $body .= ' and ' . ($count - 3) . ' other(s)';
        } else {
            if ($count > 2) {
                $body .= ', ' . $lastComments[1]->getPoster()->getUsername() . ' and ' . ($count - 2) . ' other(s)';
            } else {
                $body .= ' and ' . $lastComments[1]->getPoster()->getUsername();
            }
        }
        $body .= ' ' . $text;
        return $body;
    }

    private function createNotif($commentId, $userId, $body) {
        $notifRow = array(
            'notification_id' => -1,
            'user_id' => $userId,
            'notification_txt' => $body,
            'notification_link' => 'index.php/comments/show-comment/' . $commentId,
            'notification_date' => DateFormatter::getNow()->format(Globals::getDateTimeFormat('mysql', true)),
            'notification_isread' => 0
        );
        return parent::getCreationHelper()->createNotification($notifRow, Globals::getDateTimeFormat('mysql', true));
    }

}
