<?php

/**
 * ReviewSqlDB
 * This is a class that handles review SQL database functions
 * @package dao
 * @subpackage dao.review
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewSqlDB extends SqlSuper implements ReviewDao {

    /**
     * The review dist database
     * @var ReviewDistDao 
     */
    private $_reviewDistDB;

    /**
     * The comment database
     * @var CommentDao
     */
    private $_commentDB;

    /**
     * The general dist database
     * @var GeneralDistDao
     */
    private $_genDistDB;

    /**
     * The game database
     * @var GameDao
     */
    private $_gameDB;

    /**
     * The vote database
     * @var VoteDao
     */
    private $_voteDB;

    /**
     * The user database
     * @var UserDao
     */
    private $_userDB;

    /**
     * The review table
     * @var string
     */
    private $_revT;

    public function __construct($connection, $commentDB, $genDistDB, $gameDB, $reviewDistDB, $voteDB, $userDB) {
        parent::__construct($connection);
        $this->init($commentDB, $genDistDB, $gameDB, $reviewDistDB, $voteDB, $userDB);
    }

    private function init($commentDB, $genDistDB, $gameDB, $reviewDistDB, $voteDB, $userDB) {
        $this->_commentDB = $commentDB;
        $this->_genDistDB = $genDistDB;
        $this->_reviewDistDB = $reviewDistDB;
        $this->_gameDB = $gameDB;
        $this->_voteDB = $voteDB;
        $this->_userDB = $userDB;
        $this->_revT = Globals::getTableName('review');
    }

    /**
     * add
     * Adds a review to the database
     * @param Review $review
     * @return int $id
     * @throws DBException
     */
    public function add(DaoObject $review) {
        if (!$review instanceof Review) {
            throw new DBException('The object you tried to add was not a review object', NULL);
        }
        $rev = $this->getByString($review->getTitle());
        if ($rev && !$review->getIsUserReview()) {
            throw new DBException('The database already contains a review with this title');
        }
        if ($this->_gameDB->getByString($review->getGame()->getName())) {
            if (!$review->getIsUserReview()) {
                throw new DBException('The database already contains a review for this game');
            }
        }
        if ($this->getUserReviewForGameAndUser($review->getGame()->getId(), $review->getWriter()->getId()) !== -1) {
            throw new DBException('You have already written a review for this game');
        }
        $revId = $this->addReviewCore($review);
        $this->addGoodBadTagsFull($revId, $review->getGoods(), 'good');
        $this->addGoodBadTagsFull($revId, $review->getBads(), 'bad');
        $this->addGoodBadTagsFull($revId, $review->getTags(), 'tag');
        if (!$review->getIsUserReview()) {
            $this->addHeaderImage($revId, $review->getHeaderImg());
            $this->addAllGalleryPics($revId, $review->getGallery());
        }
        return parent::getLastId();
    }

    /**
     * addReviewCore
     * Helper function to add the core of a review to the database
     * @param Review $review
     * @return int $revId
     */
    private function addReviewCore(Review $review) {
        $gameId = '';
        if (!$review->getIsUserReview()) {
            $gameId = $this->addGame($review->getGame());
        } else {
            $gameId = $this->_gameDB->getByString($review->getGame()->getName())->getId();
        }
        $platformId = $this->_gameDB->search('platform', $review->getReviewedOn());
        $query = 'INSERT INTO ' . $this->_revT . '(users_writer_id, game_id,';
        $query .= 'platforms_platform_id, review_title, review_score, review_txt,';
        $query .= 'review_video_url, review_created, is_user_review) ';
        $query .= $this->getReviewValuesString();
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':writId' => $review->getWriter()->getId(),
            ':gameId' => $gameId,
            ':platId' => $platformId,
            ':tit' => $review->getTitle(),
            ':score' => $review->getScore(),
            ':txt' => $review->getText(),
            ':vidUrl' => $review->getVideoUrl(),
            ':created' => $review->getCreatedStr(Globals::getDateTimeFormat('mysql', FALSE)),
            ':isUser' => $review->getIsUserReview()
        );
        $statement->execute($queryArgs);
        $revId = parent::getLastId();
        return $revId;
    }

    /**
     * addAllGalleryPics
     * Helper function to add all gallery pics to the database
     * @param type $revId
     * @param type $gallery
     */
    private function addAllGalleryPics($revId, $gallery) {
        parent::triggerIdNotFound($revId, 'review');
        foreach ($gallery as $key => $pic) {
            $this->addGalleryImage($revId, $pic);
        }
    }

    /**
     * get
     * Returns a Review from the database if the id matches
     * @param int $id
     * @return Review
     * @throws DBException
     */
    public function get($id) {
        parent::triggerIdNotFound($id, 'review');
        $query = $this->buildGetQuery('review_id');
        $review = $this->getReview($id, $query);
        return $review;
    }

    /**
     * getByString
     * Returns a Review from the database if the title matches
     * @param string $identifier
     * @return Review
     * @throws DBException
     */
    public function getByString($identifier) {
        $query = $this->buildGetQuery('review_title');
        $review = $this->getReview($identifier, $query);
        return $review;
    }

    /**
     * getReview
     * Helper function to return a Review
     * This function is used by get and getByString
     * @param int $id
     * @param string $query
     * @return Review
     */
    private function getReview($id, $query) {
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        if ($result) {
            return $this->createReview($result);
        }
    }

    /**
     * remove
     * Removes the game with this id from the database
     * @param int $id     
     */
    public function remove($id) {
        parent::triggerIdNotFound($id, 'review');
        $rev = $this->get($id);
        $gameId = $rev->getGame()->getId();
        $isUserRev = $rev->getIsUserReview();
        $imgIds = '';
        if (!$isUserRev) {
            $imagesIds = $this->_reviewDistDB->getGalleryIds($id);
            foreach ($imagesIds as $imgId) {
                $this->removeGalleryImage($id, $imgId['images_image_id'], TRUE);
            }
            $userReviews = $this->getUserReviewsForGame($gameId);
            foreach ($userReviews as $userReview) {
                if ($userReview instanceof Review) {
                    $userRevId = $userReview->getId();
                    $this->removeReviews($userRevId);
                }
            }
        }
        $this->removeReviews($id);
        if (!$isUserRev) {
            $this->_gameDB->remove($gameId);
        }
    }

    /**
     * removeReviews
     * Helper function to assist remove function with removal of all related rows
     * @param int $reviewId
     */
    private function removeReviews($reviewId) {
        $notifId1 = $this->getVotedNotifId($reviewId, 1);
        $notifId2 = $this->getVotedNotifId($reviewId, 2);
        $notifId3 = $this->getVotedNotifId($reviewId, 3);
        $commentedNotifId = $this->getCommentedNotification($reviewId);
        $rootComments = $this->getRootComments($reviewId);

        $this->removeUserRelatedRecords('review_vote', $reviewId);
        $this->removeUserRelatedRecords('good', $reviewId);
        $this->removeUserRelatedRecords('review_userScore', $reviewId);
        $this->removeRootComments($reviewId, $rootComments);


        $this->removeUserRelatedRecords('review', $reviewId);

        $this->removeRelatedNotifications($notifId1);
        $this->removeRelatedNotifications($notifId2);
        $this->removeRelatedNotifications($notifId3);
        $this->removeRelatedNotifications($commentedNotifId);
    }

    private function removeUserRelatedRecords($objName, $reviewId) {
        $t = Globals::getTableName($objName);
        $query = 'DELETE FROM ' . $t;
        $query .= ' WHERE review_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();
    }

    /**
     * getCommentedNotification
     * Helper function to assist the remove function
     * Returns the id of the notification for commented on or -1 if none are found
     * @param int $reviewId
     * @return int $notifId
     */
    public function getCommentedNotification($reviewId) {
        $t = Globals::getTableName('review_comment');
        $query = 'SELECT commented_on_notif_id as notif_id FROM ' . $t;
        $query .= ' WHERE reviews_review_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        $notifId = -1;
        if (!empty($result)) {
            $notifId = $result['notif_id'];
        }
        return $notifId;
    }

    /**
     * removeRootComments
     * Helper function to assist the remove function
     * Removes all root comments linked to this review
     * @param int $reviewId
     * @param Comment[] $rootComments
     */
    private function removeRootComments($reviewId, $rootComments) {
        if ($rootComments && is_array($rootComments)) {
            foreach ($rootComments as $rootComment) {
                $this->removeRootComment($reviewId, $rootComment->getId());
            }
        }
    }

    /**
     * removeRelatedNotifications
     * Helper function to assist the remove function
     * Removes the notifications linked to this review
     * @param type $notifId
     */
    private function removeRelatedNotifications($notifId) {
        if ($notifId && $notifId > -1) {
            $t = Globals::getTableName('notification');
            $query = 'DELETE FROM ' . $t;
            $query .= ' WHERE notification_id = ?';
            $statement = parent::prepareStatement($query);
            $statement->bindParam(1, $notifId);
            $statement->execute();
        }
    }

    /**
     * getReviews
     * Returns all reviews with these options.
     * possible options: 
     * -where: string platform, string genre, string gbt, string gameName, 
     *  stringtitle, string txt, boolean userReview
     * -having: int minScore, int maxScore
     * -order: string col, string order
     * -limit: int limit 
     * @param array $options      
     * @return Review[]
     */
    public function getReviews($options) {
        $t = $this->_revT;
        $query = '';
        $queryArgs = array();
        $select = 'SELECT r.*';
        $from = ' FROM ' . $t . ' r';
        $optionsQuery = $this->getReviewsBuildQuery($options, $from, $queryArgs);
        $query = $select . $from . $optionsQuery;
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, TRUE);
        if ($result) {
            $reviews = array();
            foreach ($result as $row) {
                $rev = $this->createReview($row);
                array_push($reviews, $rev);
            }
            return $reviews;
        }
        return -1;
    }

    /**
     * getReviewBuildQuery
     * Helper function to assist the getReviews function
     * Builds and returns the where, having, orderby query parts
     * @param string[] $options
     * @param string[] $queryArgs
     * @return string
     */
    private function getReviewsBuildQuery($options, &$from, &$queryArgs) {
        if (!$options || !is_array($options) || empty($options)) {
            return '';
        }
        $where = $this->buildWhereQuery($options['whereOptions'], $from, $queryArgs);
        $having = $this->buildHavingQuery($options['havingOptions'], $queryArgs);
        $order = $this->buildOrderQuery($options['orderOptions']);
        $limit = $this->buildLimitQuery($options['limitOptions'], $queryArgs);
        return $where . $having . $order . $limit;
    }

    /**
     * buildWhereQuery
     * Builds the where part of the query for the getReviews with options
     * possible options: string platform, string genre, string gbt, 
     * int userReview, string gameName, string title, string text
     * @param array $whereOptions     
     * @param string $from
     * @param array $queryArgs
     * @return string
     */
    private function buildWhereQuery($whereOptions, &$from, &$queryArgs) {
        if ($whereOptions && !empty($whereOptions)) {
            $where = '';
            if (array_key_exists('platform', $whereOptions)) {
                $from .= ' INNER JOIN game_platform gp ON r.game_id = gp.game_id ';
                $from .= ' INNER JOIN platforms plat ON gp.platform_id = plat.platform_id';
                $where .= empty($where) ? ' WHERE ' : ' OR ';
                $where .= ' plat.platform_name LIKE :platLike ';
                $queryArgs[':platLike'] = '%' . $whereOptions['platform'] . '%';
            }
            if (array_key_exists('genre', $whereOptions)) {
                $from .= ' INNER JOIN game_genre gg ON r.game_id = gg.game_id ';
                $from .= ' INNER JOIN genres gen ON gg.genre_id = gen.genre_id';
                $where .= empty($where) ? ' WHERE ' : ' OR ';
                $where .= ' gen.genre_name LIKE :genLike ';
                $queryArgs[':genLike'] = '%' . $whereOptions['genre'] . '%';
            }
            if (array_key_exists('gbt', $whereOptions)) {
                $from .= ' INNER JOIN goods_bads_tags gbt ON r.review_id = gbt.review_id ';
                $where .= empty($where) ? ' WHERE ' : ' OR ';
                $where .= ' gbt.good_bad_tag_txt LIKE :gbtLike ';
                $queryArgs[':gbtLike'] = '%' . $whereOptions['gbt'] . '%';
            }
            if (array_key_exists('gameName', $whereOptions)) {
                $from .= ' INNER JOIN games game ON r.game_id = game.game_id ';
                $where .= empty($where) ? ' WHERE ' : ' OR ';
                $where .= ' game.game_name LIKE :gameLike ';
                $queryArgs[':gameLike'] = '%' . $whereOptions['gameName'] . '%';
            }
            if (array_key_exists('title', $whereOptions)) {
                $where .= empty($where) ? ' WHERE ' : ' OR ';
                $where .= ' r.review_title LIKE :revTitLike ';
                $queryArgs[':revTitLike'] = '%' . $whereOptions['title'] . '%';
            }
            if (array_key_exists('txt', $whereOptions)) {
                $where .= empty($where) ? ' WHERE ' : ' OR ';
                $where .= ' r.review_txt LIKE :revTxtLike ';
                $queryArgs[':revTxtLike'] = '%' . $whereOptions['txt'] . '%';
            }
            if (array_key_exists('userReview', $whereOptions)) {
                $where .= empty($where) ? ' WHERE ' : ' AND ';
                $where .= ' is_user_review = :userRev ';
                $queryArgs[':userRev'] = $whereOptions['userReview'];
            }
            $where .= ' GROUP BY r.review_id';
            return $where;
        }
        return '';
    }

    /**
     * buildHavingQuery
     * Builds the having part of the query for the getReviews with options
     * possible options: int $minScore, int $maxScore
     * @param array $havingOptions     
     * @param string $from     
     * @param array $queryArgs
     * @return string
     */
    private function buildHavingQuery($havingOptions, &$queryArgs) {
        if ($havingOptions && !empty($havingOptions)) {
            $having = '';
            if (array_key_exists('minScore', $havingOptions)) {
                $having .= empty($having) ? ' HAVING ' : ' AND ';
                $having .= ' r.review_score >= :scoreMin ';
                $queryArgs[':scoreMin'] = $havingOptions['minScore'];
            }
            if (array_key_exists('maxScore', $havingOptions)) {
                $having .= empty($having) ? ' HAVING ' : ' AND ';
                $having .= ' r.review_score <= :scoreMax ';
                $queryArgs[':scoreMax'] = $havingOptions['maxScore'];
            }
            return $having;
        }
        return '';
    }

    /**
     * buildOrderQuery
     * Builds the OrderBy part of the query for the getReviews with options
     * @param array $orderOptions
     * @param array $queryArgs
     * @return string
     */
    private function buildOrderQuery($orderOptions) {
        if ($orderOptions && !empty($orderOptions)) {
            $order = ' ORDER BY ';
            $order .= $orderOptions['col'] . ' ' . $orderOptions['order'];
            return $order;
        }
        return '';
    }

    /**
     * buildLimitQuery
     * Builds the Limit part of the query for the getReviews with options
     * @param array $limitOptions
     * @param array $queryArgs
     * @return string
     */
    private function buildLimitQuery($limitOptions, &$queryArgs) {
        if ($limitOptions && !empty($limitOptions)) {
            if ($limitOptions['limit']) {
                $queryArgs[':limit'] = $limitOptions['limit'];
                $limit = ' LIMIT :limit';
            }
            return $limit;
        }
        return '';
    }

    /**
     * getUserReviewsForGame
     * Returns all reviews for this game, written by non-admin users.
     * Can be limited
     * @param int $gameId
     * @param int $limit
     * @return Review[]
     */
    public function getUserReviewsForGame($gameId, $limit = -1) {
        return $this->getUserReviewsFor('game_id', $gameId, $limit);
    }

    /**
     * getUserReviewsForUser
     * Returns all the reviews written by user with this id.
     * Can be limited
     * @param int $userId
     * @param int $limit
     * @return Review[]
     */
    public function getUserReviewsForUser($userId, $limit = -1) {
        return $this->getUserReviewsFor('users_writer_id', $userId, $limit);
    }

    /**
     * getUserReviewsFor
     * Helper function that returns all user reviews where the id column matches.
     * Used by getUserReviewsForGame and getUserReviewsForUser
     * @param string $idCol
     * @param int $id
     * @param int $limit
     */
    private function getUserReviewsFor($idCol, $id, $limit = -1) {
        $t = $this->_revT;
        $queryArgs = array(
            ':id' => $id
        );
        $limitPart = '';
        if ($limit > -1) {
            $limitPart = ' LIMIT :limit';
            $queryArgs[':limit'] = $limit;
        }
        $query = 'SELECT * FROM ' . $t;
        $query .= ' WHERE ' . $idCol . ' = :id AND is_user_review = 1 ' . $limitPart;
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, TRUE);
        if ($result) {
            $userReviews = array();
            foreach ($result as $row) {
                $rev = $this->createReview($row);
                array_push($userReviews, $rev);
            }
            return $userReviews;
        }
        return -1;
    }

    /**
     * getUserReviewForGameAndUser
     * Returns the user review for this game and this review is present.
     * Else returns -1
     * @param int $gameId
     * @param int $userId
     * @return Review (or -1 if not present)
     */
    public function getUserReviewForGameAndUser($gameId, $userId) {
        $t = $this->_revT;
        $query = 'SELECT * FROM ' . $t;
        $query .= ' WHERE game_id = :gameId AND users_writer_id = :userId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':gameId' => $gameId,
            'userId' => $userId
        );
        $statement->execute($queryArgs);
        $result = parent::fetch($statement, FALSE);
        if ($result) {
            return $this->createReview($result);
        }
        return -1;
    }

    private function getReviewedOn($platId) {
        $t = Globals::getTableName('platform');
        $query = 'SELECT platform_name FROM ' . $t;
        $query .= ' WHERE platform_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $platId);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        return $result['platform_name'];
    }

    /**
     * updateReviewCore
     * Updates a review withoud updating the characteristics of the related game
     * @param int $reviewId
     * @param string $reviewedOn
     * @param string $title
     * @param int $score
     * @param string $text
     * @param string $videoUrl
     * @param Image $headerImg
     */
    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, $headerImg) {
        $t = $this->_revT;
        $platId = $this->_gameDB->search('platform', $reviewedOn);
        $query = 'UPDATE ' . $t;
        $query .= ' SET platforms_platform_id = :platId, review_title = :tit,';
        $query .= ' review_score = :score, review_txt = :txt, review_video_url = :vidUrl';
        $query .= ' WHERE review_id = :revId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':revId' => $reviewId,
            ':platId' => $platId,
            ':tit' => $title,
            ':score' => $score,
            ':txt' => $text,
            ':vidUrl' => $videoUrl
        );
        $statement->execute($queryArgs);
        if ($headerImg) {
            $this->updateHeaderImage($reviewId, $headerImg);
        }
    }

    /**
     * updateGameCore
     * Updates the game for this review
     * @param int $gameId
     * @param Game $game
     */
    public function updateGameCore($gameId, Game $game) {
        $this->_gameDB->updateGameCore($gameId, $game);
    }

    /**
     * addHeaderImage
     * Adds the header image to this review
     * @param int $reviewId
     * @param Image $image
     */
    public function addHeaderImage($reviewId, Image $image) {
        $id = $this->getImgId($image);
        $this->_reviewDistDB->addHeaderImage($reviewId, $id);
    }

    /**
     * addGalleryImage
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param Image $image
     * @return int $imageId
     */
    public function addGalleryImage($reviewId, Image $image) {
        $id = $this->getImgId($image);
        $this->_reviewDistDB->addGalleryImage($reviewId, $id);
    }

    /**
     * getHeaderImage
     * Returns the header image for this review
     * @param itn $reviewId
     * @return Image $headerImage
     */
    public function getHeaderImage($reviewId) {
        $id = $this->_reviewDistDB->getHeaderImageId($reviewId);
        return $this->_genDistDB->getImage($id);
    }

    /**
     * getGallery
     * Returns the image gallery for this review
     * @param int $reviewId
     * @return Image[]
     */
    public function getGallery($reviewId) {
        $ids = $this->_reviewDistDB->getGalleryIds($reviewId);
        $gallery = array();
        foreach ($ids as $id) {
            $img = $this->_genDistDB->getImage($id['images_image_id']);
            $gallery[$id['images_image_id']] = $img;
        }
        return $gallery;
    }

    /**
     * getImgId
     * Helper function to get the image id
     * @param Image $image
     */
    private function getImgId(Image $image) {
        return $this->_genDistDB->addImage($image);       
    }

    /**
     * updateHeaderImage
     * Updates the header image of this review and deletes the old one if delete is true
     * Updates the header image of this review
     * @param type $reviewId
     * @param Image $image
     */
    public function updateHeaderImage($reviewId, Image $image, $delete = false) {
        $prevId = FALSE;
        if ($delete) {
            $prevId = $this->get($reviewId)->getHeaderImg()->getId();
        }
        $id = $this->getImgId($image);
        $this->_reviewDistDB->updateHeaderImage($reviewId, $id);
        if ($delete) {
            $this->_genDistDB->removeImage($prevId);
        }
    }

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     */
    public function removeGalleryImage($reviewId, $imageId, $permanent = false) {
        parent::triggerIdNotFound($imageId, 'image');
        $this->_reviewDistDB->removeGalleryImage($reviewId, $imageId);
        if ($permanent) {
            $this->_genDistDB->removeImage($imageId);
        }
    }

    /**
     * addGood
     * Adds a good the database
     * @param int $reviewId
     * @param string $good    
     */
    public function addGood($reviewId, $good) {
        return $this->_reviewDistDB->addGoodBadTag($reviewId, $good, 'good');
    }

    /**
     * addBad
     * Adds a bad the database
     * @param int $reviewId
     * @param string $bad    
     */
    public function addBad($reviewId, $bad) {
        return $this->_reviewDistDB->addGoodBadTag($reviewId, $bad, 'bad');
    }

    /**
     * addTag
     * Adds a tag the database
     * @param int $reviewId
     * @param string $tag    
     */
    public function addTag($reviewId, $tag) {
        return $this->_reviewDistDB->addGoodBadTag($reviewId, $tag, 'tag');
    }

    /**
     * getGoods
     * Returns all the good points for a review
     * @param int $reviewId
     * @return string[]
     */
    public function getGoods($reviewId) {
        return $this->_reviewDistDB->getGoodsBadsTags($reviewId, 'good');
    }

    /**
     * getGoods
     * Returns all the good points for a review
     * @param int $reviewId
     * @return string[]
     */
    public function getBads($reviewId) {
        return $this->_reviewDistDB->getGoodsBadsTags($reviewId, 'bad');
    }

    /**
     * getGoods
     * Returns all the good points for a review
     * @param int $reviewId
     * @return string[]
     */
    public function getTags($reviewId) {
        return $this->_reviewDistDB->getGoodsBadsTags($reviewId, 'tag');
    }

    /**
     * removeGood
     * Removew a good from the database
     * @param int $reviewId
     * @param string $good
     * @throws DBException
     */
    public function removeGood($reviewId, $good) {
        $this->_reviewDistDB->removeGoodBadTag($reviewId, $good, 'good');
    }

    /**
     * removeBad
     * Removew a bad from the database
     * @param int $reviewId
     * @param string $bad
     * @throws DBException
     */
    public function removebad($reviewId, $bad) {
        $this->_reviewDistDB->removeGoodBadTag($reviewId, $bad, 'bad');
    }

    /**
     * removeTag
     * Removew a tag from the database
     * @param int $reviewId
     * @param string $tag
     * @throws DBException
     */
    public function removeTag($reviewId, $tag) {
        $this->_reviewDistDB->removeGoodBadTag($reviewId, $tag, 'tag');
    }

    //HERE
    /**
     * addRootComment
     * Adds a root comment to this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int commentId
     * @param Comment $rootComment
     */
    public function addRootComment($reviewId, Comment $rootComment) {
        $commentId = $this->_commentDB->add($rootComment);
        $this->_reviewDistDB->addRootComment($reviewId, $commentId, $rootComment);
        return $commentId;
    }

    /**
     * getReviewRootcomments
     * Returns all root comments for the review with this id   
     * @param int $reviewId
     * @param int $limit
     * @return Comment[]
     * @throws DBException
     */
    public function getRootComments($reviewId, $limit = 100) {
        return $this->_commentDB->getReviewRootComments($reviewId, $limit);
    }

    /**
     * updateRootCommentNotification
     * Updates the notification id for this review comment combination
     * @param int $reviewId
     * @param int $commentId
     * @param int $notifId
     */
    public function updateRootCommentNotification($reviewId, $commentId, $notifId) {
        $this->_reviewDistDB->updateRootCommentNotification($reviewId, $commentId, $notifId);
    }

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param int $reviewId
     * @param int $commentId
     */
    public function removeRootComment($reviewId, $commentId) {
        $this->_reviewDistDB->removeRootComment($reviewId, $commentId);
        $this->_commentDB->remove($commentId);
    }

    /**
     * AddUserScore
     * Adds a user score to the user scores
     * @param int $reviewId
     * @param int $userId
     * @param int $userScore
     */
    public function addUserScore($reviewId, $userId, $userScore) {
        $this->_reviewDistDB->addUserScore($reviewId, $userId, $userScore);
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
        return $this->_reviewDistDB->userRatedReview($reviewId, $userId);
    }

    /**
     * getUserScores     
     * Returns the user scores for this review
     * @param int $reviewId
     * @return array $userScores
     */
    public function getUserScores($reviewId) {
        return $this->_reviewDistDB->getUserScores($reviewId);
    }

    /**
     * updateUserScore
     * Updates the user score for this user and review combination
     * @param int $reviewId
     * @param int $userId
     * @param int $newScore
     */
    public function updateUserScore($reviewId, $userId, $newScore) {
        $this->_reviewDistDB->updateUserScore($reviewId, $userId, $newScore);
    }

    /**
     * RemoveUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     */
    public function removeUserScore($reviewId, $userId) {
        $this->_reviewDistDB->removeUserScore($reviewId, $userId);
    }

    /**
     * addVoter
     * Adds a voter to this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function addVoter($reviewId, $voterId, $notifId, $voteFlag) {
        $this->_voteDB->addVoter('review', $reviewId, $voterId, $notifId, $voteFlag);
    }

    /**
     * getVotedNotifId
     * Get the id of the notification linked to this vote
     * @param int $reviewId
     * @param int $voteFlag
     * @return int
     */
    public function getVotedNotifId($reviewId, $voteFlag) {
        return $this->_voteDB->getVotedNotifId('review', $reviewId, $voteFlag);
    }

    /**
     * getVoters
     * Returns all voters for the given params 
     * @param int $reviewId
     * @param int $flag (if -1, search all flags)
     * @param int $limit
     * @return Vote[]
     */
    public function getVoters($reviewId, $flag = -1, $limit = -1) {
        return $this->_voteDB->getVoters('review', $reviewId, $flag, $limit);
    }

    /**
     * getVotersCount
     * Returns the number of voters for this flag
     * @param int $reviewId
     * @param int $flag
     * @return int
     */
    public function getVotersCount($reviewId, $flag) {
        return $this->_voteDB->getVotersCount('review', $reviewId, $flag);
    }

    /**
     * hasVoted
     * Returns if a user voted on this Review.
     * Return value is the flag related to this vote or -1 if the user did 
     * not yet vote on this Review     
     * @param int $reviewId
     * @param int $userId
     * @return int
     */
    public function hasVoted($reviewId, $userId) {
        return $this->_voteDB->hasVoted('review', $reviewId, $userId);
    }

    /**
     * updateVoterNotif
     * Updates the notification linked to this vote
     * @param int $reviewId
     * @param int $voterId
     * @param int $notifId
     * @throws DBException     
     */
    public function updateVoterNotif($reviewId, $voterId, $notifId) {
        $this->_voteDB->updateVoterNotif('review', $reviewId, $voterId, $notifId);
    }

    /**
     * updateVoter
     * Updates a voter for this review
     * @param int $reviewId
     * @param int $voterId
     * @param int $voterFlag
     */
    public function updateVoter($reviewId, $voterId, $voterFlag) {
        $this->_voteDB->updateVoter('review', $reviewId, $voterId, $voterFlag);
    }

    /**
     * removeVoter
     * Removes a voter from this review
     * @param int $reviewId
     * @param int $voterId
     */
    public function removeVoter($reviewId, $voterId) {
        $this->_voteDB->removeVoter('review', $reviewId, $voterId);
    }

    /**
     * addGame
     * Adds a game to the database
     * @param Game $game
     * @return int $gameId
     */
    private function addGame(Game $game) {
        $gameId = $this->_gameDB->add($game);
        return $gameId;
    }

    /**
     * getGame
     * returns the game for this review
     * @param type $reviewId
     */
    public function getGame($reviewId) {
        $id = $this->getGameId($reviewId);
        $game = $this->_gameDB->get($id);
        return $game;
    }

    /**
     * getGameId
     * Helper function to get the id of a game when the review id is given
     * @param int $reviewId
     * @return int $gameId
     */
    private function getGameId($reviewId) {
        $t = $this->_revT;
        $query = 'SELECT game_id FROM ' . $t;
        $query .= ' WHERE review_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        return $result['game_id'];
    }

    /**
     * getReviewValuesString
     * Helper function to build the values string for the add query
     * @return string $valuesString
     */
    private function getReviewValuesString() {
        $values = ' VALUES (';
        $values .= ':writId, :gameId, :platId, :tit, :score, :txt, :vidUrl, :created, :isUser';
        $values .= ')';
        return $values;
    }

    /**
     * addGoodBadTagsFull     
     * Adds all goods, bads or tags from an array to the database
     * @param int $revId
     * @param string[] $arr
     * @param string $type
     */
    private function addGoodBadTagsFull($revId, $arr, $type) {
        $this->_reviewDistDB->addGoodBadTagsFull($revId, array_values($arr), $type);
    }

    /**
     * getWriter
     * Returns the writer of this review
     * @param int $reviewId
     * @return UserSimple $writer
     */
    public function getWriter($reviewId) {
        $writerId = $this->getWriterId($reviewId);
        $writer = $this->_userDB->getSimple($writerId);
        return $writer;
    }

    /**
     * getWriterId
     * Helper function to get the id of the writer of this review
     * @param int $reviewId
     * @return int $userId
     * @throws DBException
     */
    private function getWriterId($reviewId) {
        parent::triggerIdNotFound($reviewId, 'review');
        $t = $this->_revT;
        $query = 'SELECT users_writer_id as id FROM ' . $t;
        $query .= ' WHERE review_id = ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $reviewId);
        $statement->execute();
        $result = parent::fetch($statement, FALSE);
        return $result['id'];
    }

    /**
     * createReview
     * Helper function to create a review 
     * @param array $row
     * @return Review
     */
    private function createReview($row) {
        $reviewId = $row['review_id'];
        $writer = $this->getWriter($reviewId);
        $game = $this->getGame($reviewId);
        $reviewedOn = $this->getReviewedOn($row['platforms_platform_id']);
        $headerPic = $this->getHeaderImage($reviewId);
        $gallery = $this->getGallery($reviewId);
        $userScores = $this->getUserScores($reviewId);
        $rootComments = $this->getRootComments($reviewId);
        $voters = $this->getVoters($reviewId);
        $goods = $this->getGoods($reviewId);
        $bads = $this->getBads($reviewId);
        $tags = $this->getTags($reviewId);
        return parent::getCreationHelper()->createReview($row, $writer, $game, $reviewedOn, $headerPic, $gallery, $userScores, $rootComments, $voters, $goods, $bads, $tags);
    }

    /**
     * buildGetQuery
     * Helper function for some of the get methods
     * Returns the query needed for some of the get methods
     * @param string $whereCol
     * @return string
     */
    private function buildGetQuery($whereCol) {
        $query = 'SELECT * FROM ' . $this->_revT . ' WHERE ' . $whereCol . ' = ?';
        return $query;
    }

}
