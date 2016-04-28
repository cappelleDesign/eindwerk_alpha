<?php

/**
 * Comment
 * @package model
 * @subpackage domain.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Comment implements DaoObject {

    /**
     * The user id
     * @var int 
     */
    private $_id = -1;

    /**
     * The id of this comment's parent.
     * If this id is the same as the id of the 
     * comment then this comment is the root comment.
     * @var int 
     */
    private $_parentId;

    /**
     * The poster of the comment
     * @var UserSimple 
     */
    private $_poster;

    /**
     * The id of the Review this comment belongs to
     * @var int 
     */
    private $_reviewId;

    /**
     * The body of the comment
     * @var string
     */
    private $_body;

    /**
     * Time this was posted
     * @var DateTime 
     */
    private $_created;

    /**
     * Assoc array with all voters form = voters(voterId=>info(userName => voter username,voteFlag => 1/2/3)
     * @var array 
     */
    private $_voters;

    public function __construct($parentId, UserSimple $poster, $reviewId, $body, $created, $voters, $dateFormat) {
        $this->init();
        $this->setParentId($parentId);
        $this->setPoster($poster);
        $this->setReviewId($reviewId);
        $this->setBody($body);
        $this->setCreated($created, $dateFormat);        
        $this->setVoters($voters);
    }

    public function init() {
        $this->_voters = [];
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setParentId($parentId) {
        $this->_parentId = $parentId;
    }

    public function setPoster(UserSimple $poster) {
        $this->_poster = $poster;
    }

    public function setReviewId($reviewId) {
        $this->_reviewId = $reviewId;
    }

    public function setBody($body) {
        $this->_body = $body;
    }

    public function setCreated($created, $dateFormat) {
        $date = DateTime::createFromFormat($dateFormat, $created);
        $this->_created = $date;
    }

    public function setVoters($voters) {
        $this->_voters = $voters;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getParentId() {
        return $this->_parentId;
    }

    public function getPoster() {
        return $this->_poster;
    }

    public function getReviewId() {
        return $this->_reviewId;
    }

    public function getBody() {
        return $this->_body;
    }

    public function getCreated() {
        return $this->_created;
    }
    
    public function getVoters() {
        return $this->_voters;
    }

    /* ---------------------------------------------------------------------- */

    /**
     * addVoter
     * Adds a new voter to this comment.
     * The voteFlag can be 1 (downvote), 2 (upvote) or 3 (diamond)
     * @param int $voterId
     * @param string $voterName
     * @param int $voteFlag
     */
    public function addVoter($voterId, $voterName, $voteFlag) {
        $this->_voters[$voterId] = array('userName' => $voterName, 'voteFlag' => $voteFlag);
    }

    /**
     * removeVoter
     * removes a voter from this comment
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
            $this->_voters[$voterId]['voteFlag'] = $voteFlag;
        }
    }

    /**
     * getCreatedStr
     * returns the creation date and time as string with given format.
     * format should be a php datetime format string.
     * @param string $format
     * @return string
     */
    public function getCreatedStr($format) {
        return $this->_created->format($format);
    }

    /**
     * getNumberOfVotes
     * returns the total vote count for this comment
     * @return int $votes total number of votes
     */
    public function getNumberOfVotes() {
        $votes = 0;
        foreach($this->_voters as $voter) {
            if($voter['voteFlag'] < 2){
                $votes --;
            } else {
                $votes ++;
            }
        }
        return $votes;
    }

    /**
     * getHasDiamond
     * checks if the comment has already got a diamond
     * @return boolean
     */
    public function getHasDiamond() {
        return isset(array_column($this->_voters,'username','voteFlag')['3']);
    }
    
    public function jsonSerialize() {
        $arr = array();
        //TODO implement
        return $arr;
    }

}
