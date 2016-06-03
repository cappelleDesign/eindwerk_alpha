<?php

class VoteSqlDB extends SqlSuper implements VoteDao {

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
    public function addVoter($objectName, $objectId, $voterId, $notifId, $voteFlag) {
        if ($this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('This user alsready voted on this ' . $objectName);
        }
        $idColName = $this->getIdColName($objectName);
        $query = 'INSERT INTO ' . Globals::getTableName($objectName . '_vote') . '(' . $idColName . ', users_voter_id, voted_on_notif_id, vote_flag)';
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

    /**
     * updateVoter
     * Updates a voter from an object
     * @param sting $objectName
     * @param int $objectId
     * @param int $voterId
     * @param int $voteFlag
     * @throws DBException
     */
    public function updateVoter($objectName, $objectId, $voterId, $voteFlag) {
        if (!$this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('No row found for a vote on this ' . $objectName);
        }
        $combo = Globals::getTableName($objectName . '_vote');
        $idColName = $this->getIdColName($objectName);
        $query = 'UPDATE ' . $combo . ' SET vote_flag = :flag WHERE ' . $idColName . ' = :objectId AND users_voter_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':flag' => $voteFlag,
            ':objectId' => $objectId,
            ':userId' => $voterId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateVoterNotif
     * Updates the link between an vote and the notification
     * @param string $objectName
     * @param int $objectId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException
     */
    public function updateVoterNotif($objectName, $objectId, $voterId, $notifId) {
        if (!$this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('No row found for a vote on this ' . $objectName);
        }
        $combo = Globals::getTableName($objectName . '_vote');
        $idColName = $this->getIdColName($objectName);
        $query = 'UPDATE ' . $combo . ' SET voted_on_notif_id = :notifId WHERE ' . $idColName . ' = :objectId AND users_voter_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':notifId' => $notifId,
            ':objectId' => $objectId,
            ':userId' => $voterId
        );
        $statement->execute($queryArgs);
    }

    /**
     * removeVoter
     * Removes a voter from an object
     * @param string $objectName
     * @param int $objectId
     * @param int $voterId
     * @throws DBException
     */
    public function removeVoter($objectName, $objectId, $voterId) {
        if (!$this->rowPresent($objectName, $objectId, $voterId)) {
            throw new DBException('No row found for a vote on this ' . $objectName);
        }
        $idColName = $this->getIdColName($objectName);
        $query = 'DELETE FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idColName . ' = :objectId AND users_voter_id = :voterId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':objectId' => $objectId,
            ':voterId' => $voterId
        );
        $statement->execute($queryArgs);
    }

    /**
     * getVotedNotifId
     * Returns the id of a vote on an object
     * @param string $objectName
     * @param int $objectId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($objectName, $objectId, $voteFlag) {
        $idColName = $this->getIdColName($objectName);
        $queryArgs = array(
            ':objectId' => $objectId,
        );
        $flagPart = '';
        if ($voteFlag != -1) {
            $flagPart = 'AND vote_flag = :voteFlag';
            $queryArgs[':voteFlag'] = $voteFlag;
        }
        $query = 'SELECT * FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idColName . ' = :objectId ' . $flagPart;
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

    /**
     * getVoters
     * returns all votes for an object         
     * @param string objectName
     * @param int $objectId
     * @param int $flag
     * @param $limit
     * @return Vote[] $voters
     */
    public function getVoters($objectName, $objectId, $flag = -1, $limit = -1) {
        //FIXME created should be voted timestamp for correct order
        $userT = Globals::getTableName('user');
        $combo = Globals::getTableName($objectName . '_vote');
        $objectT = Globals::getTableName($objectName);
        $idCol = $this->getIdColName($objectName);
        $queryArgs = array(
            ':object_id' => $objectId,
        );
        $flagPart = '';
        $limitPart = '';
        if ($flag > -1) {
            $flagPart = 'AND ' . $combo . '.vote_flag = :flag';
            $queryArgs[':flag'] = $flag;
        }
        if ($limit > -1) {
            $limitPart = 'LIMIT :limit';
            $queryArgs[':limit'] = $limit;
        }
        $query = 'SELECT ' . $userT . '.user_id, ' . $combo . '.' . $idCol . ',' . $combo . '.voted_on_notif_id,' . $userT . '.user_name,' . $combo . '.vote_flag, ' . $objectT . '.' . $objectName . '_created' .
                ' FROM ' . $combo .
                ' INNER JOIN ' . $userT . ' ON ' . $combo . '.users_voter_id = ' . $userT . '.user_id' .
                ' INNER JOIN ' . $objectT . ' ON ' . $combo . '.' . $idCol . ' = ' . $objectT . '.' . $idCol .
                ' WHERE ' . $combo . '.' . $idCol . ' = :object_id ' . $flagPart .
                ' ORDER BY ' . $objectName . '_created DESC ' . $limitPart;
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        $voters = array();
        foreach ($result as $row) {
            $voters[$row['user_id']] = parent::getCreationHelper()->createVote($row);
        }
        return $voters;
    }

    /**
     * getVotersCount
     * Returns the number of votes on this object with this flag 
     * @param string $objectName
     * @param int $objectId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($objectName, $objectId, $flag) {
        $userT = Globals::getTableName('user');
        $combo = Globals::getTableName($objectName . '_vote');
        $idCol = $this->getIdColName($objectName);
        $query = 'SELECT COUNT(*) AS count' .
                ' FROM ' . $combo . ' INNER JOIN ' . $userT . ' ON ' . $combo . '.users_voter_id = ' . $userT . '.user_id' .
                ' WHERE ' . $combo . '.' . $idCol . ' = :object_id ' . 'AND ' . $combo . '.vote_flag = :flag';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':object_id' => $objectId,
            ':flag' => $flag
        );
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        if (!$result) {
            return -1;
        }
        return $result[0]['count'];
    }

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
    public function hasVoted($objectName, $objectId, $userId) {
        $flag = -1;
        $idColName = $this->getIdColName($objectName);
        $query = 'SELECT * FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idColName . ' =  :id AND users_voter_id = :userId';
        $statement = $this->prepareStatement($query);
        $queryArgs = array(
            ':id' => $objectId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        if (!empty($result)) {
            $flag = $result[0]['vote_flag'];
        }
        return $flag;
    }

    /**
     * rowPresent
     * Checks if this row is present in the database
     * @param string $objectName
     * @param int $objectId
     * @param int $voterId
     * @return int
     */
    private function rowPresent($objectName, $objectId, $voterId) {
        $idColName = $this->getIdColName($objectName);
        $query = 'SELECT COUNT(*) FROM ' . Globals::getTableName($objectName . '_vote') . ' WHERE ' . $idColName . ' = ? AND users_voter_id = ?';
        $statement = $this->prepareStatement($query);
        $statement->bindParam(1, $objectId);
        $statement->bindParam(2, $voterId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();
        return $result[0]['COUNT(*)'];
    }

    /**
     * getIdColName
     * Returns the id column header for this object in the combo table
     * @param string $objectName
     * @return string
     * @throws DBException
     */
    private function getIdColName($objectName) {
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
