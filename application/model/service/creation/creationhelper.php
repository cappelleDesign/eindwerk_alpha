<?php

/**
 * CreationHelper
 * This is a helper(factory) class to create objects from sql rows
 * @package service
 * @subpackage service.creation
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class CreationHelper {

    /**
     * The user creation helper
     * @var UserCreationHelper 
     */
    private $_userCreationHelper;

    /**
     * The comment creation helper
     * @var CommentCreationHelper 
     */
    private $_commentCreationHelper;

    /**
     * The review creation helper
     * @var ReviewCreationHelper
     */
    private $_reviewCreationHelper;

    public function __construct() {
        $this->init();
    }

    private function init() {
        $this->_userCreationHelper = new UserCreationHelper();
        $this->_commentCreationHelper = new CommentCreationHelper();
        $this->_reviewCreationHelper = new ReviewCreationHelper();
    }

    /**
     * * createUserSimple
     * Creates a UserSimple object from an SQL row, 
     *  an Avatar object and a UserRole object.     
     * @param array $row
     * @param boolrean $detailed
     * @param Avatar $avatar
     * @param UserRole $userRole
     * @return UserSimple (or UserDetailed if $detailed flag is true)
     * @throws ServiceException
     */
    public function createUserSimple($row, Avatar $avatar, UserRole $userRole) {
        return $this->_userCreationHelper->createUserSimple($row, $avatar, $userRole);
    }

    /**
     * * createDetailedUser
     * Creates a UserDetailed object from a UserSimple,an SQL row, 
     *  $recentNotifications, $lastComment and $achievements.
     * @param UserSimple $simpleUser
     * @param array $row   
     * @param Notification[] $recentNotifications
     * @param Comment $lastComment
     * @param Achievement[] $achievements
     * @return UserDetailed
     * @throws ServiceException
     */
    public function createUserDetailed(UserSimple $simpleUser, $row, $recentNotifications, $lastComment, $achievements) {
        return $this->_userCreationHelper->createUserDetailed($simpleUser, $row, $recentNotifications, $lastComment, $achievements);
    }

    /**
     * createComment
     * Creates a comment object from an SQL row, a UserSimple and a voters array
     * @param array $row
     * @param UserSimple $poster
     * @param array $voters
     * @return Comment
     * @throws ServiceException
     */
    public function createComment($row, UserSimple $poster, $voters) {
        return $this->_commentCreationHelper->createComment($row, $poster, $voters);
    }

    /**
     * createNotification
     * Creates a notification object from an SQL row
     * @param array $row
     * @return Notification
     * @throws ServiceException
     */
    public function createNotification($row, $format) {
        return $this->_userCreationHelper->createNotification($row, $format);
    }

    /**
     * crateAvatar
     * Creates an Avatar object from an SQL row and an image
     * @param array $row
     * @param Image $image
     * @return Avatar
     * @throws ServiceException
     */
    public function createAvatar($row, Image $image) {
        return $this->_userCreationHelper->createAvatar($row, $image);
    }

    /**
     * createAchievement
     * Creates an Achievement object from an SQL row and an Image object
     * @param array $row
     * @param Image $image
     * @return Achievement
     * @throws ServiceException
     */
    public function createAchievement($row, Image $image) {
        return $this->_userCreationHelper->createAchievement($row, $image);
    }

    /**
     * createUserRole
     * Creates a UserRole object from an SQL row
     * @param array $row
     * @return UserRole
     * @throws ServiceException
     */
    public function createUserRole($row) {
        return $this->_userCreationHelper->createUserRole($row);
    }

    /**
     * createVote
     * Creates a Vote object from an SQL row
     * @param array $row
     * @return Vote
     * @throws ServiceException
     */
    public function createVote($row, $idCol) {
        return $this->_commentCreationHelper->createVote($row, $idCol);
    }

    /**
     * createGame
     * Create a Game object from an SQL row, a platforms array and a genres array
     * @param array $row
     * @param array $platforms
     * @param arrya $genres
     * @return Game
     * @throws ServiceException
     */
    public function createGame($row, $platforms, $genres) {
        return $this->_reviewCreationHelper->createGame($row, $platforms, $genres);
    }

    /**
     * createReview
     * Creates a Review object from an SQL row, a UserSimple Object, a Game object,
     * an Image object, an Image array, an array for userScores, a Comments array
     * and 3 string arrays for goods, bads and tags
     * @param string[] $row
     * @param UserSimple $writer
     * @param Game $game
     * @param string $reviewedOn
     * @param Image $headerPic
     * @param Image[] $gallery
     * @param array $userScores (int userId, int score)
     * @param Comment[] $rootComments
     * @param array $voters
     * @param string[] $goods
     * @param string[] $bads
     * @param string[] $tags
     */
    public function createReview($row, UserSimple $writer, Game $game, $reviewedOn, $headerPic, $gallery, $userScores, $rootComments, $voters, $goods, $bads, $tags) {
        return $this->_reviewCreationHelper->createReview($row, $writer, $game, $reviewedOn, $headerPic, $gallery, $userScores, $rootComments, $voters, $goods, $bads, $tags);
    }

}
