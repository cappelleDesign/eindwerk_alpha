<?php

interface VoteDao {

    public function addVoter($objectName, $objectId, $voterId, $notifId, $voteFlag);

    public function removeVoter($objectName, $objectId, $voterId);

    public function updateVoter($objectName, $objectId, $voterId, $voteFlag);
    
    public function getVotedNotifId($objectName, $objectId, $voteFlag);
}
