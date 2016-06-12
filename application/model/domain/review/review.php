<?php

/**
 * Review
 * @package model
 * @subpackage domain.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class Review extends VoteFuncionalityObject implements DaoObject {

    /**
     * The id of this review
     * @var int 
     */
    private $_id = -1;

    /**
     * The writer of this review
     * @var UserSimple
     */
    private $_writer;

    /**
     * The game this review is about
     * @var Game
     */
    private $_game;

    /**
     * The platform the game was reviewed on
     * @var string 
     */
    private $_reviewedOn;

    /**
     * The title of this review
     * @var string
     */
    private $_title;

    /**
     * The general review score (1-10 out of 10)
     * @var int
     */
    private $_score;

    /**
     * The full review text
     * @var string
     */
    private $_text;

    /**
     * The url to the video review linked to this review
     * @var string
     */
    private $_videoUrl;

    /**
     * The date and time this review was created
     * @var DateTime
     */
    private $_created;

    /**
     * The header image to display for this review
     * @var Image
     */
    private $_headerImg;

    /**
     * The scores users gave this game .
     * assoc array (userId , score)
     * @var array 
     */
    private $_userScores;

    /**
     * Comments on this review that are not comments on comments.
     * assoc array (commentId , comment) 
     * @var Comment[]
     */
    private $_rootComments;

    /**
     * Array with all the good points of the game.     
     * @var string[]
     */
    private $_goods;

    /**
     * Array with all the bad points of the game.     
     * @var string[]
     */
    private $_bads;

    /**
     * Aarray with all the tags for the game.
     * @var string[]
     */
    private $_tags;

    /**
     * Assoc array containing all images related to this review.
     * Form: gallery(imageId , Image)
     * @var array 
     */
    private $_gallery;

    /**
     * To quickly check if a review is created by a user;
     * @var boolean  
     */
    private $_isUserReview;

    public function __construct(UserSimple $writer, Game $game, $reviewedOn, $title, $score, $text, $videoUrl, $created, $headerImg, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format, $isUserReview = false) {
        parent::__construct($voters);
        $this->setWriter($writer);
        $this->setGame($game);
        $this->setReviewedOn($reviewedOn);
        $this->setTitle($title);
        $this->setScore($score);
        $this->setText($text);
        $this->setVideoUrl($videoUrl);
        $this->setCreated($created, $format);
        $this->setHeaderImg($headerImg);
        $this->setGallery($gallery);
        $this->setUserScores($userScores);
        $this->setRootComments($rootComments);
        $this->setGoods($goods);
        $this->setBads($bads);
        $this->setTags($tags);
        $this->setIsUserReview($isUserReview);
    }

    /* ---------------------------------------------------------------------- */

    public function setId($id = -1) {
        $this->_id = $id;
    }

    public function setWriter(UserSimple $writer) {
        $this->_writer = $writer;
    }

    public function setGame(Game $game) {
        $this->_game = $game;
    }

    public function setReviewedOn($reviewedOn) {
        $this->_reviewedOn = $reviewedOn;
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function setScore($score) {
        $this->_score = $score;
    }

    public function setText($text) {
        $this->_text = $text;
    }

    public function setVideoUrl($videoUrl) {
        if ($videoUrl) {
            $this->_videoUrl = $videoUrl;
        } else {
            $this->_videoUrl = '';
        }
    }

    public function setCreated($created, $format) {
        $date = DateTime::createFromFormat($format, $created);       
        $this->_created = $date;
    }

    public function setHeaderImg($headerImg) {
        $this->_headerImg = $headerImg;
    }

    public function setUserScores($userScores) {
        if ($userScores) {
            $this->_userScores = $userScores;
        } else {
            $this->_userScores = array();
        }
    }

    public function setRootComments($rootComments) {
        if ($rootComments) {
            $this->_rootComments = $rootComments;
        } else {
            $this->_rootComments = array();
        }
    }

    public function setGoods($goods) {
        if ($goods) {
            $this->_goods = $goods;
        } else {
            $this->_goods = array();
        }
    }

    public function setBads($bads) {
        if ($bads) {
            $this->_bads = $bads;
        } else {
            $this->_bads = array();
        }
    }

    public function setTags($tags) {
        if ($tags) {
            $this->_tags = $tags;
        } else {
            $this->_tags = array();
        }
    }

    public function setGallery($gallery) {
        if ($gallery) {
            $this->_gallery = $gallery;
        } else {
            $this->_gallery = array();
        }
    }

    public function setIsUserReview($isUserReview) {
        $this->_isUserReview = $isUserReview;
    }

    /* ---------------------------------------------------------------------- */

    public function getId() {
        return $this->_id;
    }

    public function getWriter() {
        return $this->_writer;
    }

    public function getGame() {
        return $this->_game;
    }

    public function getReviewedOn() {
        return $this->_reviewedOn;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getScore() {
        return $this->_score;
    }

    public function getText() {
        return $this->_text;
    }

    public function getVideoUrl() {
        return $this->_videoUrl;
    }

    public function getCreated() {
        return $this->_created;
    }

    public function getHeaderImg() {
        return $this->_headerImg;
    }

    public function getUserScores() {
        return $this->_userScores;
    }

    public function getRootComments() {
        return $this->_rootComments;
    }

    public function getGoods() {
        return $this->_goods;
    }

    public function getBads() {
        return $this->_bads;
    }

    public function getTags() {
        return $this->_tags;
    }

    public function getGallery() {
        return $this->_gallery;
    }

    public function getIsUserReview() {
        return $this->_isUserReview;
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
     * addUserScore
     * Adds a new user score to game this review is about.
     * @param int $userId
     * @param int $userScore
     */
    public function addUserScore($userId, $userScore) {
        $this->_userScores[$userId] = $userScore;
    }

    /**
     * updateUserScore
     * Changes the score a user gave for the game this review is about.
     * @param int $userId
     * @param int $userScore
     */
    public function updateUserScore($userId, $userScore) {
        if (array_key_exists($userId, $this->getUserScores())) {
            $this->_userScores[$userId] = $userScore;
        }
    }

    /**
     * getAverageUserScore
     * Returns the average of all the user scores
     * @return int
     */
    public function getAverageUserScore() {
        $sum = array_sum(array_values($this->getUserScores()));
        $length = count($this->getUserScores());
        $avg = $sum / $length;
        return $avg;
    }

    /**
     * addRootComment
     * Adds a root comment to this review
     * @param int $id
     * @param Comment $rootComment
     */
    public function addRootComment($id, Comment $rootComment) {
        $this->_rootComments[$id] = $rootComment;
    }

    /**
     * removeRootComment
     * Removes a root comment from this review
     * @param int $id
     */
    public function removeRootComment($id) {
        if (array_key_exists($id, $this->getRootComments())) {
            unset($this->_rootComments[$id]);
        }
    }

    /**
     * addGood
     * Adds a good to this review     
     * @param String $good
     */
    public function addGood($good) {
//        FIXME TOOK EASY WAY OUT
        $this->_goods[$good] = $good;
    }

    /**
     * removeGood
     * Removes a good from this review
     * @param string $good
     */
    public function removeGood($good) {
        if (array_key_exists($good, $this->getGoods())) {
            unset($this->_goods[$good]);
        }
    }

    /**
     * addBad
     * Adds a bad to this review
     * @param String $bad
     */
    public function addBad($bad) {
//        FIXME TOOK EASY WAY OUT
        $this->_bads[$bad] = $bad;
    }

    /**
     * removeBad
     * Removes a bad from this review
     * @param string $bad
     */
    public function removeBad($bad) {
        if (array_key_exists($bad, $this->getBads())) {
            unset($this->_bads[$bad]);
        }
    }

    /**
     * addTag
     * Adds a tag to this review
     * @param String $tag
     */
    public function addTag($tag) {
//        FIXME TOOK EASY WAY OUT
        $this->_tags[$tag] = $tag;
    }

    /**
     * removeTag
     * Removes a Tag from this review
     * @param string $tag
     */
    public function removeTag($tag) {
        if (array_key_exists($tag, $this->getTags())) {
            unset($this->_tags[$tag]);
        }
    }

    /**
     * addGalleryImage
     * Adds an image to the gallery of the review
     * @param int $id
     * @param Image $image
     */
    public function addGalleryImage(Image $image) {
        $this->_gallery[$image->getId()] = $image;
    }

    /**
     * removeFromGallery
     * Removes an image from this review's gallery
     * @param int $imageId
     */
    public function removeFromGallery($imageId) {
        if (array_key_exists($imageId, $this->getGallery())) {
            unset($this->_gallery[$imageId]);
        }
    }

    /**
     * jsonSerialize
     * Returns object as Json array
     * @return array
     */
    public function jsonSerialize() {
        $arr = array();
        //TODO implement
        return $arr;
    }

}
