<?php

/**
 * Vote
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Vote {

    /**
     * The voter's userId
     * @var int
     */
    private $_voterId;

    /**
     * The id of the object that was voted on
     * @var int
     */
    private $_votedOnId;

    /**
     * The id of the notification linked to the vote
     * @var int 
     */
    private $_votedOnNotifId;

    /**
     * The voter's username
     * @var string
     */
    private $_voterName;

    /**
     * The flag that show what kind of vote it was (1 = downvote, 2 = upvote, 3 = diamond) 
     * @var int 
     */
    private $_voteFlag;

    public function __construct($voterId, $votedOnId, $votedOnNotifId, $voterName, $voteFlag) {
        $this->setVoterId($voterId);
        $this->setVotedOnId($votedOnId);
        $this->setVotedOnNotifId($votedOnNotifId);
        $this->setVoterName($voterName);
        $this->setVoteFlag($voteFlag);
    }

    public function getVoterId() {
        return $this->_voterId;
    }

    public function getVotedOnId() {
        return $this->_votedOnId;
    }

    public function getVotedOnNotifId() {
        return $this->_votedOnNotifId;
    }

    public function getVoterName() {
        return $this->_voterName;
    }

    public function getVoteFlag() {
        return $this->_voteFlag;
    }

    public function setVoterId($voterId) {
        $this->_voterId = $voterId;
    }

    public function setVotedOnId($votedOnId) {
        $this->_votedOnId = $votedOnId;
    }

    public function setVotedOnNotifId($votedOnNotifId) {
        $this->_votedOnNotifId = $votedOnNotifId;
    }

    public function setVoterName($voterName) {
        $this->_voterName = $voterName;
    }

    public function setVoteFlag($voteFlag) {
        $this->_voteFlag = $voteFlag;
    }

    public function jsonSerialize() {
        $arr = array();
        //TODO implement
        return $arr;
    }

}
