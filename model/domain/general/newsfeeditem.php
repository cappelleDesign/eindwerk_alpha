<?php

/**
 * Newsfeed
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class NewsfeedItem implements DaoObject {

    /**
     * The id of the newsfeed item
     * @var int 
     */
    private $_id;

    /**
     * The id of the writer of this newsfeed item
     * @var int 
     */
    private $_writerId;

    /**
     * The nmae of the writer of this newsfeed item
     * @var string
     */
    private $_writerName;

    /**
     * The image linked to this newsfeed item
     * @var Image
     */
    private $_image;

    /**
     * The subject of the newsfeed item
     * @var string 
     */
    private $_subject;

    /**
     * The long text of this newsfeed item
     * @var string 
     */
    private $_body;

    /**
     * The date and time when the newsfeed item was created
     * @var DateTime
     */
    private $_created;

    public function __construct($writerId, $writerName, $image, $subject, $body, $created, $dateFormat) {
        $this->setWriterId($writerId);
        $this->setWriterName($writerName);
        $this->setImage($image);
        $this->setSubject($subject);
        $this->setBody($body);
        $this->setCreated($created, $dateFormat);
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setWriterId($writerId) {
        $this->_writerId = $writerId;
    }

    public function setWriterName($writerName) {
        $this->_writerName = $writerName;
    }

    public function setImage($image) {
        $this->_image = $image;
    }

    public function setSubject($subject) {
        $this->_subject = $subject;
    }

    public function setBody($body) {
        $this->_body = $body;
    }

    public function setCreated($created, $dateFormat) {
        $date = DateTime::createFromFormat($dateFormat, $created);
        $this->_created = $date;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getWriterId() {
        return $this->_writerId;
    }

    public function getWriterName() {
        return $this->_writerName;
    }

    public function getImage() {
        return $this->_image;
    }

    public function getSubject() {
        return $this->_subject;
    }

    public function getBody() {
        return $this->_body;
    }

    public function getCreated() {
        return $this->_created;
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

}
