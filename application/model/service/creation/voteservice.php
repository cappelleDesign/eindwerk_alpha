<?php

/**
 * VoteService
 * This is a class that handles vote service functions
 * @package service
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class VoteService {

    /**
     * The object the sub class handles (comment, review,..)
     * @var string 
     */
    private $_subClassHandles;

    /**
     * The database dat is used
     * is a subclass of vote dao
     * @var VoteDao
     */
    private $_activeDB;

    /**
     * The notification handler
     * @var notificationHandler 
     */
    private $_notificationHandler;

    protected function voteInit($subClassHandles, $activeDB, $notifHandler) {
        $this->_subClassHandles = $subClassHandles;
        $this->_activeDB = $activeDB;
        $this->_notificationHandler = $notifHandler;
    }

    /**
     * addVoter
     * Adds a voter to an object with vote funcionality and notifies the creater 
     * of the parent object
     * @param int $objectId
     * @param int $voterId
     * @param string $voterName
     * @param int $voteFlag
     * @throws ServiceException
     */
    public function addVoter($objectId, $voterId, $voterName, $voteFlag) {
        try {
            $this->_activeDB->startTransaction();
            $flagPrev = $this->_activeDB->hasVoted($objectId, $voterId);
            if ($flagPrev === -1) {
                $notifId = $this->_notificationHandler->notifyParentWriterVoted($this->_subClassHandles, $objectId, $voterId, $voterName, $voteFlag);
                $this->_activeDB->addVoter($objectId, $voterId, $notifId, $voteFlag);
            } else if ($flagPrev === $voteFlag) {
                $this->removeVoter($objectId, $voterId, $voteFlag);
            } else {
                $this->updateVoter($objectId, $voterId, $voterName, $voteFlag, $flagPrev);
            }
            $this->_activeDB->endTransaction();
        } catch (Exception $ex) {
            $this->_activeDB->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateVoter
     * Updates a voter of an object with vote funcionality and notifies the creater 
     * of the parent object
     * @param int $objectId
     * @param int $voterId
     * @param string $voterName
     * @param int $voteFlag
     * @param int $prevFlag
     * @throws ServiceException
     */
    public function updateVoter($objectId, $voterId, $voterName, $voteFlag, $prevFlag) {
        try {
            $notifPrev = $this->_activeDB->getVotedNotifId($objectId, $prevFlag);
            $notifId = $this->_notificationHandler->notifyParentWriterVoted($this->_subClassHandles, $objectId, $voterId, $voterName, $voteFlag);
            $this->_activeDB->updateVoter($objectId, $voterId, $voteFlag);
            $this->_activeDB->updateVoterNotif($objectId, $voterId, $notifId);
            $this->_notificationHandler->notifyParentWriterVoted($this->_subClassHandles, $objectId, $voterId, -1, $prevFlag, $notifPrev);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeVoter
     * removes a voter from an object with vote funcionality and deletes or updates
     * the linked notification
     * @param int $objectId
     * @param int $voterId
     * @param int $voteFlag
     * @throws ServiceException
     */
    public function removeVoter($objectId, $voterId, $voteFlag) {
        try {
            $notifPrev = $this->_activeDB->getVotedNotifId($objectId, $voteFlag);
            $this->_activeDB->removeVoter($objectId, $voterId);

            $this->_notificationHandler->notifyParentWriterVoted($this->_subClassHandles, $objectId, $voterId, -1, $voteFlag, $notifPrev);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * hasVoted
     * Checks if a user has already voted for an object with this id
     * Return value is the flag related to this vote or -1 if the user did 
     * @param int $objectId
     * @param int $userId
     * @return int
     * @throws ServiceException
     */
    public function hasVoted($objectId, $userId) {
        try {
            return $this->_activeDB->hasVoted($objectId, $userId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

}
