<?php

/**
 * Video
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Video implements DaoObject {

    /**
     * The id of this video
     * @var int
     */
    private $_id = -1;

    /**
     * The title of this video
     * @var string
     */
    private $_title;

    /**
     * The description of this video
     * @var string
     */
    private $_desc;

    /**
     * The number of likes this video has
     * @var int 
     */
    private $_likes = 0;

    /**
     * The number of times this video has been watched
     * @var int
     */
    private $_views = 0;

    /**
     * The link to the original location of the video (e.g. youtube)
     * @var string
     */
    private $_externLink;

    /**
     * The flag representing what type of video this is.
     * 1 = let's play, 2 = podcast
     * @var int
     */
    private $_typeFlag;

    /**
     * The date this video was posted
     * @var DateTime 
     */
    private $_posted;

    /**
     * Comments on this video that are not comments on comments
     * @var Comment[]       
     */
    private $_rootComments;

    public function __construct($title, $desc, $likedNmbr, $viewedNmbr, $externLink, $typeFlag, $posted, $rootComments, $format) {
        $this->setTitle($title);
        $this->setDesc($desc);
        $this->setLikes($likedNmbr);
        $this->setViews($viewedNmbr);
        $this->setExternLink($externLink);
        $this->setTypeFlag($typeFlag);
        $this->setPosted($posted, $format);
        $this->setRootComments($rootComments);
    }

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function setDesc($desc) {
        $this->_desc = $desc;
    }

    public function setLikes($likedNmbr) {
        $this->_likes = $likedNmbr;
    }

    public function setViews($viewedNmbr) {
        $this->_views = $viewedNmbr;
    }

    public function setExternLink($externLink) {
        $this->_externLink = $externLink;
    }

    public function setTypeFlag($typeFlag) {
        $this->_typeFlag = $typeFlag;
    }

    public function setPosted($posted, $format) {
        $date = DateTime::createFromFormat($format, $posted);
        $this->_posted = $date;
    }

    public function setRootComments(array $rootComments = array()) {
        $this->_rootComments = $rootComments;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getDesc() {
        return $this->_desc;
    }

    public function getLikedNmbr() {
        return $this->_likes;
    }

    public function getExternLink() {
        return $this->_externLink;
    }

    public function getTypeFlag() {
        return $this->_typeFlag;
    }

    public function getPosted() {
        return $this->_posted;
    }

    public function getRootComments() {
        return $this->_rootComments;
    }

    /* ---------------------------------------------------------------------- */

    public function addLike() {
        $this->_likes++;
    }

    public function removeLike() {
        $this->_likes--;
    }

    public function addView() {
        $this->_views++;
    }

    /**
     * addRootComment
     * Adds a root comment to this video
     * @param int $id
     * @param Comment $rootComment
     */
    public function addRootComment($id, Comment $rootComment) {
        $this->_rootComments[$id] = $rootComment;
    }

    /**
     * removeRootComment
     * Removes a root comment from this video
     * @param int $id
     */
    public function removeRootComment($id) {
        if (array_key_exists($id, $this->getRootComments())) {
            unset($this->_rootComments[$id]);
        }
    }

    /**
     * getPostedStr
     * returns the creation date and time as string with given format.
     * format should be a php datetime format string.
     * @param string $format
     * @return string
     */
    public function getPostedStr($format) {
        return $this->_created->format($format);
    }
    
    public function jsonSerialize() {
        //TODO IMPLEMENT
    }

}
