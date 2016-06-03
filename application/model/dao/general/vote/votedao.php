<?php

interface VoteDao {

    /**
     * getVoters
     * Returns all the voters for a comment
     * @param int $commentId
     * @param int $flag (optional)
     * @param int $limit (optional)
     * @return Vote[]
     */
    public function getVoters($objectName, $objectId, $flag = -1, $limit = -1);

    /**
     * getVotersCount
     * Returns the number of votes on this object with this flag 
     * @param string $objectName
     * @param int $objectId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($objectName, $objectId, $flag);

    /**
     * addVoter
     * Adds a voter to an object
     * @param string $objectName
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @param int $voteFlag
     * @throws DBException
     */
    public function addVoter($objectName, $objectId, $voterId, $notifId, $voteFlag);

    /**
     * removeVoter
     * Removes a voter from an object
     * @param string $objectName
     * @param int $objectId
     * @param int $voterId
     * @throws DBException
     */
    public function removeVoter($objectName, $objectId, $voterId);

    /**
     * updateVoter
     * Updates a voter from an object
     * @param sting $objectName
     * @param int $objectId
     * @param int $voterId
     * @param int $voteFlag
     * @throws DBException
     */
    public function updateVoter($objectName, $objectId, $voterId, $voteFlag);

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param sting $objectName
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($objectName, $objectId, $voterId, $notifId);
    
    /**
     * getVotedNotifId
     * Returns the id of a vote on an object
     * @param string $objectName
     * @param int $objectId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($objectName, $objectId, $voteFlag);

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
    public function hasVoted($objectName, $objectId, $userId);
}
