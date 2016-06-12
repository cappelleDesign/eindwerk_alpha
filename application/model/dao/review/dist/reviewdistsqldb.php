<?php

/**
 * ReviewDistSqlDB
 * This is a class that handles review dist SQL database functions
 * @package dao
 * @subpackage dao.review.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewDistSqlDB extends SqlSuper implements ReviewDistDao {

    /**
     * An instance of the general dist database to help create some objects
     * @var GeneralDistDao 
     */
    private $_genDistDao;

    /**
     * The table used for user score related functions
     * @var string 
     */
    private $_userScoreT;

    /**
     * The table used for good, bad and tag related function
     * @var string
     */
    private $_gbtT;

    /**
     * The review_image table
     * @var string 
     */
    private $_imgT;

    /**
     * The review has comments table
     * @var string 
     */
    private $_commentT;

    public function __construct($connection, $genDistDb) {
        parent::__construct($connection);
        $this->init($genDistDb);
    }

    private function init($generalDistDao) {
        $this->_genDistDao = $generalDistDao;
        $this->_userScoreT = Globals::getTableName('review_userScore');
        $this->_gbtT = Globals::getTableName('good');
        $this->_imgT = Globals::getTableName('review_image');
        $this->_commentT = Globals::getTableName('review_comment');
    }

    /**
     * AddUserScore
     * Adds a user score to the user scores
     * @param int $reviewId
     * @param int $userId
     * @param int $userScore
     */
    public function addUserScore($reviewId, $userId, $userScore) {
        $t = $this->_userScoreT;
        if ($this->userRatedReview($reviewId, $userId) > -1) {
            $this->updateUserScore($reviewId, $userId, $userScore);
        } else {
            $query = 'INSERT INTO ' . $t;
            $query .= ' (review_id, user_id, score)';
            $query .= ' VALUES (:revId, :userId, :score)';
            $statement = parent::prepareStatement($query);
            $queryArgs = array(
                ':revId' => $reviewId,
                ':userId' => $userId,
                ':score' => $userScore
            );
            $statement->execute($queryArgs);
        }
    }

    /**
     * userRatedReview
     * Checks if a user has already rated a review.
     * If the user did, return the score, else return -1
     * @param int $reviewId
     * @param int $userId
     * @return int
     */
    public function userRatedReview($reviewId, $userId) {
        $t = $this->_userScoreT;
        $query = 'SELECT score FROM ' . $t;
        $query.= ' WHERE review_id = :revId AND user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, FALSE);
        return $result ? $result['score'] : -1;
    }

    /**
     * getUserScores     
     * @param int $reviewId
     * @return array $userScores
     */
    public function getUserScores($reviewId) {
        $t = $this->_userScoreT;
        $query = 'SELECT * FROM ' . $t;
        $query .= ' WHERE review_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        $userScores = array();
        foreach ($result as $row) {
            $userScores[$row['user_id']] = $row['score'];
        }
        return $userScores;
    }

    /**
     * updateUserScore
     * Updates the user score for this user and review combination
     * @param int $reviewId
     * @param int $userId
     * @param int $newScore
     */
    public function updateUserScore($reviewId, $userId, $newScore) {
        $t = $this->_userScoreT;
        $query = 'UPDATE ' . $t . ' SET score = :score';
        $query .= ' WHERE review_id = :revId AND user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':score' => $newScore,
            ':revId' => $reviewId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * RemoveUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId) {
        $t = $this->_userScoreT;
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE review_id = :revId AND user_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':userId' => $userId
        );
        $statement->execute($queryArgs);
    }

    /**
     * addGoodBadTag
     * Adds a good, a bad or a tag to the database
     * @param int $reviewId
     * @param int $goodBadTag
     * @param string $type
     */
    public function addGoodBadTag($reviewId, $goodBadTag, $type) {
        $t = $this->_gbtT;
        if ($this->searchGBT($reviewId, $goodBadTag, $type) === -1) {
            $query = 'INSERT INTO ' . $t;
            $query .= '(review_id, good_bad_tag_txt, good_bad_tag_type)';
            $query .= ' VALUES(:revId, :body, :type)';
            $statement = parent::prepareStatement($query);
            $queryArgs = array(
                ':revId' => $reviewId,
                ':body' => $goodBadTag,
                ':type' => $type
            );
            $statement->execute($queryArgs);            
        }
    }

    /**
     * getGoodsBasTags
     * Returns all the good/bad/tag points for a review
     * @param int $reviewId
     * @param string $type
     * @return string[]
     */
    public function getGoodsBadsTags($reviewId, $type) {
        $t = $this->_gbtT;
        $query = 'SELECT good_bad_tag_txt as txt FROM ' . $t;
        $query .= ' WHERE review_id = :revId AND good_bad_tag_type = :type';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':type' => $type
        );
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, TRUE);
        $gbts = array();
        foreach ($result as $row) {
            $gbts[$row['txt']] = $row['txt'];
        }
        return $gbts;
    }

    /**
     * addGoodBadTagsFull     
     * Adds all goods, bads or tags from an array to the database
     * @param int $revId
     * @param string[] $arr
     * @param string $type
     */
    public function addGoodBadTagsFull($revId, $arr, $type) {
        $t = $this->_gbtT;
        $last = end($arr);
        $queryArgs = array();
        $query = 'INSERT INTO ' . $t . ' ';
        $query .= '(review_id, good_bad_tag_txt, good_bad_tag_type)';
        $query .= ' VALUES';
        foreach ($arr as $key => $el) {
            $query .= '(';
            $query .= ':revId' . $key . ', :gbtTxt' . $key . ', :gbtType' . $key;
            $query .= ')';
            $query .= $el === $last ? '' : ',';
            $queryArgs[':gbtTxt' . $key] = $el;
            $queryArgs[':revId' . $key] = $revId;
            $queryArgs[':gbtType' . $key] = $type;
        }
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);
    }

    /**
     * searchGBT
     * Searches for a good, bad or tag by name and returns it's id if found,
     * -1 otherwise
     * @param int $revId
     * @param string $gbtText
     * @param string $type
     */
    public function searchGBT($revId, $gbtText, $type) {
        $t = $this->_gbtT;
        $query = 'SELECT good_bad_tag_id as found FROM ' . $t;
        $query .= ' WHERE review_id = :revId AND good_bad_tag_txt = :gbtText AND good_bad_tag_type = :gbtType';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $revId,
            ':gbtText' => $gbtText,
            ':gbtType' => $type
        );
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, FALSE);
        return $result ? $result['found'] : -1;
    }

    /**
     * removeGoodBadTag
     * Removew a good, a bad or a tag from the database
     * @param int $reviewId
     * @param string $goodBadTag
     * @throws DBException
     */
    public function removeGoodBadTag($reviewId, $goodBadTag, $type) {
        $id = $this->searchGBT($reviewId, $goodBadTag, $type);
        if ($id === -1) {
            throw new DBException('Could not find a ' . $type . ' with this text: ' . $goodBadTag);
        }
        $t = $this->_gbtT;
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE good_bad_tag_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
    }

    /**
     * addHeaderImage
     * Adds the header image to this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function addHeaderImage($reviewId, $imageId) {
        $this->addImagetoReview($reviewId, $imageId, TRUE);
    }

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function addGalleryImage($reviewId, $imageId) {
        $this->addImagetoReview($reviewId, $imageId, FALSE);
    }

    private function addImagetoReview($reviewId, $imageId, $header) {
        $t = $this->_imgT;
        $query = 'INSERT INTO ' . $t;
        $query .= ' (reviews_review_id, images_image_id, headerpic)';
        $query .= ' VALUES(:revId, :imageId, :header)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':imageId' => $imageId,
            ':header' => $header
        );
        $statement->execute($queryArgs);
    }

    /**
     * getHeaderImageId
     * Returns the header image for this review
     * @param itn $reviewId
     * @return int $headerImageId
     */
    public function getHeaderImageId($reviewId) {
        $t = $this->_imgT;
        $query = 'SELECT * FROM ' . $t;
        $query .= ' WHERE reviews_review_id = :revId AND headerpic = TRUE';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId
        );
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, FALSE);
        return $result['images_image_id'];
    }

    /**
     * getGalleryIds
     * Returns the image gallery id's for this review
     * @param int $reviewId
     * @return int[]
     */
    public function getGalleryIds($reviewId) {
        $t = $this->_imgT;
        $query = 'SELECT images_image_id FROM ' . $t;
        $query .= ' WHERE reviews_review_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();
        $result = parent::fetch($statement, TRUE);
        return $result;
    }

    /**
     * updateHeaderImage
     * Updates the header image of this review
     * @param type $reviewId
     * @param int $imageId
     */
    public function updateHeaderImage($reviewId, $imageId) {
        $t = $this->_imgT;
        $query = 'UPDATE ' . $t;
        $query .= ' SET images_image_id = :imgId';
        $query .= ' WHERE reviews_review_id = :revId AND headerpic = 1';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':imgId' => $imageId,
            ':revId' => $reviewId
        );
        $statement->execute($queryArgs);
    }

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function removeGalleryImage($reviewId, $imageId) {
        $t = $this->_imgT;
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE reviews_review_id = :revId AND images_image_id = :imgId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':imgId' => $imageId
        );
        $statement->execute($queryArgs);
    }

    /**
     * addRootComment
     * Adds a root comment to this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int commentId     
     */
    public function addRootComment($reviewId, $commentId) {
        $t = $this->_commentT;
        $query = 'INSERT INTO ' . $t;
        $query .= ' (reviews_review_id, comments_comment_id, commented_on_notif_id)';
        $query .= ' VALUES(:revId, :comId, NULL)';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':comId' => $commentId
        );
        $statement->execute($queryArgs);
    }

    /**
     * updateRootCommentNotification
     * Updates the notification id for this review comment combination
     * @param int $reviewId
     * @param int $commentId
     * @param int $notifId
     */
    public function updateRootCommentNotification($reviewId, $commentId, $notifId) {
        $t = $this->_commentT;
        $query = 'UPDATE ' . $t;
        $query .= ' SET commented_on_notif_id = :notifId';
        $query .= ' WHERE reviews_review_id = :revId AND comments_comment_id = :comId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':notifId' => $notifId,
            ':revId' => $reviewId,
            ':comId' => $commentId
        );
        $statement->execute($queryArgs);
    }

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId) {
        $t = $this->_commentT;
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE reviews_review_id = :revId AND comments_comment_id = :comId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':comId' => $commentId
        );
        $statement->execute($queryArgs);
    }

}
