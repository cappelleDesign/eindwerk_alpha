<?php

/**
 * VoteFunctionalityDao
 * This is an interface that is a super class for classes that have vote abilities
 * @package dao
 * @subpackage dao
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface VoteFunctionalityDao extends Dao{

    /**
     * getVoters
     * Returns all voters for the given params 
     * @param int $objectId
     * @param int $flag (if -1, search all flags)
     * @param int $limit
     * @return Vote[]
     */
    public function getVoters($objectId, $flag = -1, $limit = -1);

    /**
     * getVotersCount
     * Returns the number of voters for this flag
     * @param int $objectId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($objectId, $flag);

    /**
     * addVoter
     * Adds a voter to a VoteFunctionalityObject
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @param int $voteFlag
     */
    public function addVoter($objectId, $voterId, $notifId, $voteFlag);

    /**
     * removeVoter
     * Removes a voter from this VoteFunctionalityObject
     * @param int $objectId
     * @param int $voterId
     */
    public function removeVoter($objectId, $voterId);

    /**
     * updateVoter
     * Updates a vote for this VoteFunctionalityObject
     * @param int $objectId
     * @param int $voterId
     * @param int $voteFlag
     */
    public function updateVoter($objectId, $voterId, $voteFlag);

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($objectId, $voterId, $notifId);

    /**
     * getVotedNotifId
     * Get the id of the notification linked to this vote
     * @param int $objectId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($objectId, $voteFlag);

    /**
     * hasVoted
     * Returns if a user voted on this object.
     * Return value is the flag related to this vote or -1 if the user did 
     * not yet vote on this VoteFunctionalityObject
     * @param string $objectName
     * @param int $objectId
     * @param int $userId
     * @return int
     */
    public function hasVoted($objectId, $userId);
}
