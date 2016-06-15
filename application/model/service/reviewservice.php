<?php

/**
 * ReviewService
 * This is a class that handles review service functions
 * @package service
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class ReviewService extends VoteService {

    /**
     * The game database
     * @var GameDao
     */
    private $_gameDb;

    /**
     * The review database
     * @var ReviewDao
     */
    private $_reviewDb;

    /**
     * The handler for notification related stuff
     * @var notificationHandler
     */
    private $_notificationHandler;

    /**
     * The defualt array for the options
     * @var string[]
     */
    private $_optionsDefault;

    public function __construct($gameDb, $reviewDb, $notificationHandler) {
        $this->init($gameDb, $reviewDb, $notificationHandler);
    }

    private function init($gameDb, $reviewDb, $notificationHandler) {
        $this->_gameDb = $gameDb;
        $this->_reviewDb = $reviewDb;
        $this->_notificationHandler = $notificationHandler;
        parent::voteInit('review', $this->_reviewDb, $this->_notificationHandler);
        $this->_optionsDefault = array(
            'whereOptions' => array(
            ),
            'havingOptions' => array(
            ),
            'orderOptions' => array(
            ),
            'limitOptions' => array(
            )
        );
    }

    /**
     * addReview
     * Adds a review to the database
     * @param Review $review
     * @throws ServiceException
     */
    public function addReview(Review $review) {
        try {
            $this->_reviewDb->startTransaction();
            $revId = $this->_reviewDb->add($review);
            $review->setId($revId);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getReview
     * Returns the review with this id
     * @param int $reviewId
     * @return Review
     * @throws ServiceException
     */
    public function getReview($reviewId) {
        try {
            $this->_reviewDb->startTransaction();
            $review = $this->_reviewDb->get($reviewId);
            $this->_reviewDb->endTransaction();
            return $review;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateReview
     * Updates a review with the review id as key
     * @param Review $review
     */
    public function updateReview(Review $review) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->updateReviewCore($review->getId(), $review->getReviewedOn(), $review->getTitle(), $review->getScore(), $review->getText(), $review->getVideoUrl(), $review->getHeaderImg());
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeReview
     * Removes the review with this id 
     * @param int $reviewId
     * @throws ServiceException
     */
    public function removeReview($reviewId) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->remove($reviewId);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getReviews
     * Returns reviews with the given options.
     * Will return -1 if no reviews are found for these options
     * @param array $options
     * @return Review
     * @throws ServiceException
     */
    public function getReviews($options = NULL) {
        if (!$options) {
            $options = $this->_optionsDefault;
        }
        try {
            $this->_reviewDb->startTransaction();
            $reviews = $this->_reviewDb->getReviews($options);
            $this->_reviewDb->endTransaction();
            return $reviews;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUserReviewsForGame
     * Returns all reviews for this game, written by non-admin users.
     * Can be limited
     * @param int $gameId
     * @param int $limit
     * @return Review[]
     * @throws ServiceException 
     */
    public function getUserReviewsForGame($gameId, $limit = -1) {
        try {
            $this->_reviewDb->startTransaction();
            $userReviews = $this->_reviewDb->getUserReviewsForGame($gameId, $limit);
            $this->_reviewDb->endTransaction();
            return $userReviews;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUserReviewsForUser
     * Returns all the reviews written by user with this id.
     * Can be limited
     * @param int $userId
     * @param int $limit
     * @return Review[]
     * @throws ServiceException
     */
    public function getUserReviewsForUser($userId, $limit = -1) {
        try {
            $this->_reviewDb->startTransaction();
            $userReviews = $this->_reviewDb->getUserReviewsForUser($userId, $limit);
            $this->_reviewDb->endTransaction();
            return $userReviews;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * userHasReviewed
     * Returns the user review for this game and this review is present.
     * Else returns -1
     * @param int $gameId
     * @param int $userId
     * @return Review (or -1 if not present)
     * @throws ServiceException
     */
    public function userHasReviewed($gameId, $userId) {
        try {
            $this->_reviewDb->startTransaction();
            $hasReviewed = $this->_reviewDb->getUserReviewForGameAndUser($gameId, $userId);
            $this->_reviewDb->endTransaction();
            return $hasReviewed;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addGalleryImageToReview
     * Adds a image to the gallery of this review
     * @param int $reviewId
     * @param Image $galleryPic
     * @throws ServiceException
     */
    public function addGalleryImageToReview($reviewId, Image $galleryPic) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->addGalleryImage($reviewId, $galleryPic);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateHeaderImage
     * Updates the header image of this review and deletes the old one permanently if delete is true
     * Updates the header image of this review
     * @param type $reviewId
     * @param Image $image
     * @throws ServiceException
     */
    public function updateHeaderImage($reviewId, Image $image, $delete = FALSE) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->updateHeaderImage($reviewId, $image, $delete);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeGalleryImage
     * Removes an image from the gallery of this review
     * @param int $reviewId
     * @param int $imageId
     * @throws ServiceException
     */
    public function removeGalleryImage($reviewId, $imageId, $permanent) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->removeGalleryImage($reviewId, $imageId, $permanent);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addGood
     * Adds a good the database
     * @param int $reviewId
     * @param string $good 
     * @throws ServiceException
     */
    public function addGood($reviewId, $good) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->addGood($reviewId, $good);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addBad
     * Adds a bad the database
     * @param int $reviewId
     * @param string $bad    
     * @throws ServiceException
     */
    public function addBadd($reviewId, $bad) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->addBad($reviewId, $bad);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addTag
     * Adds a tag the database
     * @param int $reviewId
     * @param string $tag    
     * @throws ServiceException
     */
    public function addTag($reviewId, $tag) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->addTag($reviewId, $tag);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeGood
     * Removew a good from the database
     * @param int $reviewId
     * @param string $good
     * @throws ServiceException
     */
    public function removeGood($reviewId, $good) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->removeGood($reviewId, $good);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeBad
     * Removew a bad from the database
     * @param int $reviewId
     * @param string $bad
     * @throws ServiceException
     */
    public function removeBad($reviewId, $bad) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->removeBad($reviewId, $bad);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeTag
     * Removew a tag from the database
     * @param int $reviewId
     * @param string $tag
     * @throws ServiceException
     */
    public function removeTag($reviewId, $tag) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->removeTag($reviewId, $tag);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addRootcomment
     * Adds a root comment to the review and notifies the writer of the review
     * if the review is a user review
     * @param Review $review
     * @param Comment $rootComment
     * @throws ServiceException
     */
    public function addRootComment(Review $review, Comment $rootComment) {
        try {
            $this->_reviewDb->startTransaction();
            $commentId = $this->_reviewDb->addRootComment($review->getId(), $rootComment);
            $rootComment->setId($commentId);
            if ($review->getIsUserReview()) {
                $this->_notificationHandler->notifyReviewWriterCommented($review, $rootComment);
            }
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getReviewRootcomments
     * Returns all root comments for the review with this id   
     * @param int $reviewId
     * @param int $limit
     * @return Comment[]
     * @throws ServiceException
     */
    public function getRootComments($reviewId, $limit = 100) {
        try {
            $this->_reviewDb->startTransaction();
            $comments = $this->_reviewDb->getRootComments($reviewId, $limit);
            return $comments;
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeRootComment
     * Removew a root comment from this review.
     * A root comment is a comment that is a direct child of this review
     * @param Review $review
     * @param Comment $comment
     * @throws ServiceException
     */
    public function removeRootcomment(Review $review, Comment $comment) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->removeRootComment($review->getId(), $comment->getId());
            $this->_notificationHandler->notifyReviewWriterCommented($review, $comment);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * AddUserScore
     * Adds a user score to the user scores
     * @param int $reviewId
     * @param int $userId
     * @param int $userScore
     * @throws ServiceException
     */
    public function addUserScore($reviewId, $userId, $userScore) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->addUserScore($reviewId, $userId, $userScore);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * userRatedReview
     * Checks if a user has already rated a review.
     * If the user did, return the score, else return -1
     * @param int $reviewId
     * @param int $userId
     * @return int
     * @throws ServiceException
     */
    public function hasUserRatedReview($reviewId, $userId) {
        try {
            $this->_reviewDb->startTransaction();
            $has = $this->_reviewDb->userRatedReview($reviewId, $userId);
            $this->_reviewDb->endTransaction();
            return $has;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getUserScores     
     * Returns the user scores for this review
     * @param int $reviewId
     * @return array $userScores
     * @throws ServiceException
     */
    public function getUserScores($reviewId) {
        try {
            $this->_reviewDb->startTransaction();
            $uScores = $this->_reviewDb->getUserScores($reviewId);
            $this->_reviewDb->endTransaction();
            return $uScores;
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * RemoveUserScore
     * Removes a user score from the user scores
     * @param int $reviewId
     * @param int $userId
     * @throws ServiceException
     */
    public function removeUserScore($reviewId, $userId) {
        try {
            $this->_reviewDb->startTransaction();
            $this->_reviewDb->removeUserScore($reviewId, $userId);
            $this->_reviewDb->endTransaction();
        } catch (Exception $ex) {
            $this->_reviewDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateGameCore
     * Updates the game in the database
     * @param int $gameId
     * @param Game $game
     * @param type $gameId
     * @param Game $game
     * @throws ServiceException
     */
    public function updateGameCore($gameId, Game $game) {
        try {
            $this->_gameDb->startTransaction();
            $this->_reviewDb->updateGameCore($gameId, $game);
            $this->_gameDb->endTransaction();
        } catch (Exception $ex) {
            $this->_gameDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addGenreToGame
     * Adds a genre to the game. If the genre does not yet exist in the database,
     * it will be added.
     * @param int $gameId
     * @param string $genreName 
     * @throws ServiceException
     */
    public function addGenreToGame($gameId, $genreName) {
        try {
            $this->_gameDb->startTransaction();
            $this->_gameDb->addGenreToGame($gameId, $genreName);
            $this->_gameDb->endTransaction();
        } catch (Exception $ex) {
            $this->_gameDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * removeGenreFromGame
     * Removes a genre from a game
     * @param int $gameId
     * @param string $genreName
     * @throws ServiceException
     */
    public function removeGenreFromGame($gameId, $genreName) {
        try {
            $this->_gameDb->startTransaction();
            $this->_gameDb->removeGenreFromGame($gameId, $genreName);
            $this->_gameDb->endTransaction();
        } catch (Exception $ex) {
            $this->_gameDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addPlatformToGame
     * Adds a platform to the game
     * @param int $gameId
     * @param string $platformName
     * @throws ServiceException
     */
    public function addPlatformToGame($gameId, $platformName) {
        try {
            $this->_gameDb->startTransaction();
            $this->_gameDb->addPlatformToGame($gameId, $platformName);
            $this->_gameDb->endTransaction();
        } catch (Exception $ex) {
            $this->_gameDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * searchPlatform
     * Checks if this platform exists
     * @param string $platformName
     * @return int $id if found, NULL otherwise
     * @throws ServiceException
     */
    public function searchPlatform($platformName) {
        try {
            $this->_gameDb->startTransaction();
            $platId = $this->_gameDb->search('platform', $platformName);
            $this->_gameDb->endTransaction();
            return $platId;
        } catch (Exception $ex) {
            $this->_gameDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * searchGenre
     * Checks if this genre exists
     * @param string $genreName
     * @return int $id if found, NULL otherwise
     * @throws ServiceException
     */
    public function searchGenre($genreName) {
        try {
            $this->_gameDb->startTransaction();
            $genId = $this->_gameDb->search('genre', $genreName);
            $this->_gameDb->endTransaction();
            return $genId;
        } catch (Exception $ex) {
            $this->_gameDb->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addGenre
     * Adds a genre to the database
     * @param string $genreName
     * @param string $genreDesc
     * @throws ServiceException
     */
    public function addGenre($genreName, $genreDesc) {
        try {
            $this->_gameDb->getGameDistDB()->startTransaction();
            $this->_gameDb->getGameDistDB()->addGenre($genreName, $genreDesc);
            $this->_gameDb->getGameDistDB()->endTransaction();
        } catch (Exception $ex) {
            $this->_gameDb->getGameDistDB()->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * addPlatform
     * Adds a platform to the database
     * @param string $platformName
     * @throws ServiceException
     */
    public function addPlatform($platformName) {
        try {
            $this->_gameDb->getGameDistDB()->startTransaction();
            $this->_gameDb->getGameDistDB()->addPlatform($platformName);
            $this->_gameDb->getGameDistDB()->endTransaction();
        } catch (Exception $ex) {
            $this->_gameDb->getGameDistDB()->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getGenreDesc
     * Returns the description for this genre
     * @param string $genreName
     * @throws ServiceException
     */
    public function getGenreDesc($genreName) {
        try {
            $this->_gameDb->getGameDistDB()->startTransaction();
            $genDesc = $this->_gameDb->getGameDistDB()->getGenreDesc($genreName);
            $this->_gameDb->getGameDistDB()->endTransaction();
            return $genDesc;
        } catch (Exception $ex) {
            $this->_gameDb->getGameDistDB()->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getAllGenres
     * Returns all genres from database     
     * @return array $genres
     * @throws ServiceException
     */
    public function getAllGenres() {
        try {
            $this->_gameDb->getGameDistDB()->startTransaction();
            $genres = $this->_gameDb->getGameDistDB()->getAll('genre');
            $this->_gameDb->getGameDistDB()->endTransaction();
            return $genres;
        } catch (Exception $ex) {
            $this->_gameDb->getGameDistDB()->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getAllPlatforms
     * Returns all platforms from database     
     * @return array $platforms
     * @throws ServiceException
     */
    public function getAllPlatforms() {
        try {
            $this->_gameDb->getGameDistDB()->startTransaction();
            $platforms = $this->_gameDb->getGameDistDB()->getAll('platform');
            $this->_gameDb->getGameDistDB()->endTransaction();
            return $platforms;
        } catch (Exception $ex) {
            $this->_gameDb->getGameDistDB()->cancelTransaction();
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

}

//
//try {
//    $this->_reviewDb->startTransaction();
//    $this->_reviewDb->
//    $this->_reviewDb->endTransaction();
//} catch (Exception $ex) {
//    $this->_reviewDb->cancelTransaction();
//    throw new ServiceException($ex->getMessage(), $ex);
//}
//try {
//    $this->_gameDb->startTransaction();
//    $this->_gameDb->
//    $this->_gameDb->endTransaction();
//} catch (Exception $ex) {
//    $this->_gameDb->cancelTransaction();
//    throw new ServiceException($ex->getMessage(), $ex);
//}
//try {
//    $this->_gameDb->getGameDistDb->startTransaction();
//    $this->_gameDb->getGameDistDb->
//    $this->_gameDb->getGameDistDb->endTransaction();
//} catch (Exception $ex) {
//    $this->_gameDb->getGameDistDb->cancelTransaction();
//    throw new ServiceException($ex->getMessage(), $ex);
//}