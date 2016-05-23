<?php

class VoteSqlDB extends SqlSuper implements VoteDao {

    public function addVoter($objectName, $objectId, $voterId, $notifId, $voteFlag) {
        if ($this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('This user alsready voted on this ' . $objectName);
        }
        $idRowName = $this->getIdRowName($objectName);
        $query = 'INSERT INTO ' . Globals::getTableName($objectName . '_vote') . '(' . $idRowName . ', users_voter_id, voted_on_notif_id, vote_flag)';
        $query .= 'VALUES (:objectId, :voterId, :notifId, :voteFlag)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':objectId' => $objectId,
            ':voterId' => $voterId,
            ':notifId' => $notifId,
            ':voteFlag' => $voteFlag
        );
        $statement->execute($queryArgs);
    }

    public function updateVoter($objectName, $objectId, $voterId, $voteFlag) {
        if (!$this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('No row found for a vote on this ' . $objectName);
        }
        $query = '';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
        );
        $statement->execute($queryArgs);
    }

    public function removeVoter($objectName, $objectId, $voterId) {
        if (!$this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('No row found for a vote on this ' . $objectName);
        }
        $idRowName = $this->getIdRowName($objectName);
        $query = 'DELETE FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idRowName . ' = :objectId AND users_voter_id = :voterId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':objectId' => $objectId,
            ':voterId' => $voterId
        );
        $statement->execute($queryArgs);
    }

    public function getVotedNotifId($objectName, $objectId, $voteFlag) {
        $idRowName = $this->getIdRowName($objectName);
        $queryArgs = array(
            ':objectId' => $objectId,            
        );
        $flagPart = '';
        if($voteFlag != -1) {
            $flagPart = 'AND vote_flag = :voteFlag';
            $queryArgs[':voteFlag'] = $voteFlag;
        } 
        $query = 'SELECT * FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idRowName . ' = :objectId ' . $flagPart;
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        if (empty($result)) {
            return -1;
        }
        $row = $result[0];
        return $row['voted_on_notif_id'];
    }

    private function rowPresent($objectName, $objectId, $voterId) {
        $idRowName = $this->getIdRowName($objectName);
        $query = 'SELECT COUNT(*) FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idRowName . ' = ? AND users_voter_id = ?';
        $statement = $this->prepareStatement($query);
        $statement->bindParam(1, $objectId);
        $statement->bindParam(2, $voterId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result[0]['COUNT(*)'];
    }

    private function getIdRowName($objectName) {
        switch ($objectName) {
            case 'comment':
                return 'comment_id';
            case 'review' :
                return 'review_id';
            default :
                throw new DBException('No id row name found for: ' . $objectName);
        }
    }

}
