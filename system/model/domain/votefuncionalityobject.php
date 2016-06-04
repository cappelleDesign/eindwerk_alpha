<?php

class VoteFuncionalityObject {

    /**
     * Array with all voters.
     * @var Vote[] 
     */
    private $_voters;

    public function __construct($voters) {
        $this->init();
        $this->setVoters($voters);
    }

    private function init() {
        $this->_voters = [];
    }

    public function setVoters($voters) {
        if ($voters && (!empty($voters))) {
            $this->_voters = $voters;
        }
    }

    public function getVoters() {
        return $this->_voters;
    }

    /**
     * addVoter
     * Adds a new voter to this object.
     * The voteFlag can be 1 (downvote), 2 (upvote) or 3 (diamond)
     * @param int $voterId
     * @param string $voterName
     * @param int $voteFlag
     */
    public function addVoter($voterId, $votedOnId, $votedOnNotifId, $voterName, $voteFlag) {
        $voter = new Vote($voterId, $votedOnId, $votedOnNotifId, $voterName, $voteFlag);
        $this->_voters[$voterId] = $voter;
    }

    /**
     * removeVoter
     * removes a voter from this object
     * @param int $voterId
     */
    public function removeVoter($voterId) {
        if (array_key_exists($voterId, $this->_voters)) {
            unset($this->_voters[$voterId]);
        }
    }

    /**
     * updateVoter
     * Changes the flag that represents what type of vote it was (1(downvote)/2(upvote)/3(diamond))
     * @param int $voterId
     * @param int $voteFlag
     */
    public function updateVoter($voterId, $voteFlag) {
        if (array_key_exists($voterId, $this->getVoters())) {
            $this->_voters[$voterId]->setVoteFlag($voteFlag);
        }
    }

    /**
     * getNumberOfVotes
     * returns the total vote count for this object
     * @return int $votes total number of votes
     */
    public function getNumberOfVotes() {
        $votes = 0;
        foreach ($this->_voters as $voter) {
            if ($voter->getVoteFlag() < 2) {
                $votes --;
            } else {
                $votes ++;
            }
        }
        return $votes;
    }

    /**
     * getHasDiamond
     * checks if the object has already got a diamond
     * @return boolean
     */
    public function getHasDiamond() {
        foreach ($this->_voters as $voter) {
            if ($voter->getVoteFlag() === 3) {
                return true;
            }
        }
        return false;
    }

}
