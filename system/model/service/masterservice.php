<?php

class MasterService {

    /**
     * The factory that creates the databasess
     * @var DaoFactory
     */
    private $_daoFactory;

    /**
     * The service in charge of user related actions
     * @var UserService 
     */
    private $_userService;

    /**
     * The service in charge of newsfeed related actions
     * @var NewsfeedService
     */
    private $_newsfeedService;

    /**
     * The service in charge of comment related actions
     * @var CommentService 
     */
    private $_commentService;

    /**
     * The service in charge of the review related actions
     * @var ReviewService
     */
    private $_reviewService;

    /**
     * The handler for notifications
     * @var notificationHandler 
     */
    private $_notificationHandler;

    /**
     * The file handler
     * @var FileHandler
     */
    private $_fileHandler;

    /**
     * The main menu items
     * @var MenuItem[]
     */
    private $_mainMenu;

    /**
     * The admin menu items
     * @var MenuItem[]
     */
    private $_adminMenu;

    /**
     * The profile menu items
     * @var MenuItem[]
     */
    private $_profileMenu;

    /**
     * Class to help with image sources for various sizes
     * @var imageHelper
     */
    private $_imgHelper;

    /**
     * The newsfeed database
     * @var NewsfeedDao
     */
    private $_newsfeedDB;

    /**
     * The comment database
     * @var CommentDao 
     */
    private $_commentDB;

    /**
     * The vote database
     * @var VoteDao 
     */
    private $_voteDB;

    /**
     * The general dist database
     * @var GeneralDistDao 
     */
    private $_generalDistDB;

    /**
     * The game dist database
     * @var GameDistDao
     */
    private $_gameDistDB;

    /**
     * The game database
     * @var GameDao
     */
    private $_gameDB;

    /**
     * The review database
     * @var ReviewDao
     */
    private $_reviewDB;

    /**
     * The review dist database
     * @var ReviewDistDao;
     */
    private $_reviewDistDB;

    /**
     * The user database
     * @var UserDao 
     */
    private $_userDB;

    /**
     * The user dist database
     * @var UserDistDao
     */
    private $_userDistDB;

    /**
     * The notification database
     * @var NotificationDao
     */
    private $_notificationDB;

    //TODO other services

    public function __construct($configs) {
        $this->init($configs);
    }

    private function init($configs) {
        $this->_daoFactory = new DaoFactory();
        $this->createMenus();
        $this->_imgHelper = new imageHelper();
        $this->createDatabases($configs);
        $this->createServices();
    }

    /**
     * createDatabases
     * Creates the Databases that are needed for the services     
     * @param array $configs
     */
    private function createDatabases($configs) {
        $this->_voteDB = $this->_daoFactory->getVoteDB($configs);
        $this->_generalDistDB = $this->_daoFactory->getGeneralDistDB($configs);
        $this->_notificationDB = $this->_daoFactory->getNotificationDB($configs);
        $this->_gameDistDB = $this->_daoFactory->getGameDistDB($configs);
        $this->_userDistDB = $this->_daoFactory->getUserDistDB($configs, $this->_generalDistDB, $this->_voteDB);
        $this->_userDB = $this->_daoFactory->getUserDB($configs, $this->_userDistDB, $this->_notificationDB);
        $this->_commentDB = $this->_daoFactory->getCommentDB($configs, $this->_userDB, $this->_voteDB);
        $this->_newsfeedDB = $this->_daoFactory->getNewsfeedDB($configs, $this->_userDB, $this->_generalDistDB);
        $this->_gameDB = $this->_daoFactory->getGameDB($configs, $this->_gameDistDB);
        $this->_reviewDistDB = $this->_daoFactory->getReviewDistDB($configs, $this->_generalDistDB);
        $this->_reviewDB = $this->_daoFactory->getReviewDB($configs, $this->_commentDB, $this->_generalDistDB, $this->_gameDB, $this->_reviewDistDB, $this->_voteDB, $this->_userDB);
    }

    private function createServices() {
        $this->_fileHandler = new FileHandler();
        $this->_notificationHandler = new notificationHandler($this->_userDB, $this->_commentDB, $this->_reviewDB);
        $this->_userService = new UserService($this->_userDB);
        $this->_newsfeedService = new NewsfeedService($this->_newsfeedDB);
        $this->_commentService = new CommentService($this->_commentDB, $this->_notificationHandler);
        $this->_reviewService = new ReviewService($this->_gameDB, $this->_reviewDB, $this->_notificationHandler);
    }

    private function createMenus() {
        $this->createMainMenu();
        $this->createAdminMenu();
        $this->createProfileMenu();
    }

    private function createMainMenu() {
        $menuHome = new MenuItem('home', 'Home', 'home.php');
        $menuReview = new MenuItem('reviews', 'Reviews', 'reviews.php');
        $subMenuVideo1 = new MenuItem('videos/live-streams', 'Live', 'video.php');
        $subMenuVideo2 = new MenuItem('videos/lets-plays', 'Lets plays', 'video.php');
        $subMenuVideo3 = new MenuItem('videos/podcasts', 'Podcasts', 'video.php');
        $subMenuVideo = array($subMenuVideo1, $subMenuVideo2, $subMenuVideo3);
        $menuVideo = new MenuItem('videos', 'Video', 'video.php', $subMenuVideo);
        $menuDonate = new MenuItem('donate', 'Donate', 'donate.php');
        $menuAccount = new MenuItem('account', 'Account', 'account.php');
        $menuContact = new MenuItem('contact', 'Contact', 'contact.php');
        $this->_mainMenu = array(
            $menuHome,
            $menuReview,
            $menuVideo,
            $menuDonate,
            $menuAccount,
            $menuContact
        );
    }

    private function createAdminMenu() {
        
    }

    private function createProfileMenu() {
        
    }

    /**
     * getMenu
     * Returns the menu for this type
     * @param string $type
     * @return MenuItem[]
     * @throws ServiceException
     */
    public function getMenu($type) {
        switch ($type) {
            case 'main':
                return $this->_mainMenu;
            case 'admin':
                return $this->_adminMenu;
            case 'profile':
                return $this->_profileMenu;
            default :
                throw new ServiceException('Could not get a menu list for \'' + $type + '\'', NULL);
        }
    }

    /**
     * containsMenuItem
     * @param string $action
     * @param string $type
     * @return MenuItem (or false)
     */
    public function containsMenuItem($action, $type) {
        switch ($type) {
            case 'main':
                return $this->menuItemFinder($this->_mainMenu, $action);
            case 'admin':
//                return false;
//                return $this->menuItemFinder($this->_adminMenu, $action);
            case 'profile':
                return false;
//                return $this->menuItemFinder($this->_profileMenu, $action);
            default :
                return false;
        }
    }

    /**
     * menuItemFinder
     * Helper function to check if an action is a menu related action
     * @param MenuItem[] $menu
     * @param string $action
     * @return MenuItem (or false)
     */
    private function menuItemFinder($menu, $action) {
        foreach ($menu as $menuItem) {
            if ($menuItem->getAction() === $action) {
                return $menuItem;
            }
            if ($menuItem->getSubMenu() && $this->menuItemFinder($menuItem->getSubMenu(), $action)) {
                return $menuItem;
            }
        }
        return false;
    }

    public function getImgSrcs($type, $name, $path, $img) {
        switch ($type) {
            case 'carousel' :
                return $this->_imgHelper->getCarouselSourceArray($name, $path, $img);
            case 'newsfeed' :
                return $this->_imgHelper->getNewsfeedSourceArray($name, $path, $img);
            default :
                return $this->typeNotRecognized($type);
        }
    }

    public function getUserService() {
        return $this->_userService;
    }

    public function getNewsfeedService() {
        return $this->_newsfeedService;
    }

    public function getCommentService() {
        return $this->_commentService;
    }

    public function getReviewService() {
        return $this->_reviewService;
    }

    public function getNotificationHandler() {
        return $this->_notificationHandler;
    }

    public function getFileHandler() {
        return $this->_fileHandler;
    }

    public function add($mixedObj, $type, $extra = array()) {
        $errName = '';
        switch ($type) {
            case 'comment' :
                if ($mixedObj instanceof Comment) {
                    $this->getCommentService()->addComment($mixedObj);
                    return $mixedObj;
                }
                $errName = 'comment';
                break;
            case 'newsfeed' :
                if ($mixedObj instanceof NewsfeedItem) {
                    $url = $this->addNewsfeedImg($mixedObj, $extra);
                    $this->getNewsfeedService()->addNewsfeedItem($mixedObj);
                    return $mixedObj;
                }
                $errName = 'newsfeed item';
                break;
            case 'user':
                if ($mixedObj instanceof UserDetailed) {
                    $this->getUserService()->addUser($mixedObj);
                    return $mixedObj;
                }
                $errName = 'user';
                break;
            case 'review':
                if ($mixedObj instanceof Review) {
                    $this->addImgtoReview('header', $mixedObj, $extra[0]);
                    $gallery = array_splice($extra, 1);
                    $this->addImgtoReview('gallery', $mixedObj, $gallery);
                    $this->getReviewService()->addReview($mixedObj);
                    return $mixedObj;
                }
                $errName = 'review';
                break;
            case 'avatar' :
                if ($mixedObj instanceof Avatar) {
                    $url = $this->addAvatarPic($mixedObj->getTier(), $extra);
                    $img = new Image($url, $mixedObj->getImage()->getAlt());
                    $mixedObj->setImage($img);
                    $id = $this->_generalDistDB->addAvatar($mixedObj);
                    $mixedObj->setId($id);
                    return $mixedObj;
                }
                $errName = 'avatar';
                break;
            case 'genre' :
                $this->getReviewService()->addGenre($mixedObj, $extra);
                return;
            case 'platform':
                $this->getReviewService()->addPlatform($mixedObj);
                return;

            default :
                $this->typeNotRecognized($type);
        }
        $err = 'To add a ' . $errName . ', you sould give a ' . $errName;
        throw new ServiceException($err);
    }

    public function remove($mixedObj, $type) {
        switch ($type) {
            case 'comment' :
                $this->getCommentService()->removeComment($mixedObj);
                return;
            case 'newsfeed':
                if ($mixedObj instanceof NewsfeedItem) {
                    $url = $mixedObj->getImage()->getUrl();
                    $imgId = $this->_generalDistDB->searchImage($url);
                    $this->getNewsfeedService()->removeNewsfeedItem($mixedObj->getId());
                    $this->_generalDistDB->removeImage($imgId->getId());
                    $this->getFileHandler()->removeFile('application/view/images/newsfeeditems/' . $url);
                    return;
                }
                throw new ServiceException('Needed a NewsfeedItem object to remove');
            case 'user':
                $this->getUserService()->removeUser($mixedObj);
                return true;
            case 'review':
                $this->getReviewService()->removeReview($mixedObj);
                return;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function get($id, $type) {
        switch ($type) {
            case 'user':
                return $this->getUserService()->getUser($id);
            case 'userSimple' :
                return $this->getUserService()->getSimpleUser($id);
            case 'comment' :
                return $this->getCommentService()->getComment($id);
            case 'newsfeed':
                return $this->getNewsfeedService()->getNewsfeedItem($id);
            case 'review' :
                return $this->getReviewService()->getReview($id);
            case 'avatar' :
                return $this->_userService->getAvatar($id);
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function getAll($type, $options = NULL) {
        switch ($type) {
            case 'user' :
                return $this->getUserService()->getUsers();
            case 'avatar' :
                return $this->getUserService()->getAvatars();
            case 'userRole' :
                return $this->getUserService()->getUserRoles();
            case 'achievement' :
                return $this->getUserService()->getAllAchievements();
            case 'subComment' :
                return $this->getCommentService()->getSubComments($options);
            case 'userComment' :
                return $this->getCommentService()->getCommentsForUser($options);
            case 'newsfeed' :
                return $this->getNewsfeedService()->getNewsfeed($options);
            case 'review' :
                return $this->getReviewService()->getReviews($options);
            case 'genre' :
                return $this->getReviewService()->getAllGenres();
            case 'platform' :
                return $this->getReviewService()->getAllPlatforms();
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function getByIdentifier($identifier, $type) {
        try {
            switch ($type) {
                case 'user':
                    return $this->getUserService()->getUserByStringId($identifier);
                case 'userRole' :
                    return $this->getUserService()->getUserRole($identifier); //identifier is the access flag here
                case 'achievement' :
                    return $this->getUserService()->getAchievement($identifier);
                case 'avatar' :
                    return $this->_generalDistDB->getAvatarByUrl($identifier);
                default :
                    $this->typeNotRecognized($type);
            }
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    public function handleVote($type, $objId, $voterId, $voterName, $flag) {
        switch ($type) {
            case 'comment':
                $this->getCommentService()->addVoter($objId, $voterId, $voterName, $flag);
                return;
            case 'review':
                $this->getReviewService()->addVoter($objId, $voterId, $voterName, $flag);
                return;
        }
    }

    public function addImgtoReview($type, Review $review, $fileArr) {
        $altName = $this->getFileHandler()->cleanWhiteSpace($review->getGame()->getName());
        $subFolder = $altName . '/';
        switch ($type) {
            case 'header':
                $headerName = $this->getFileHandler()->addImgFile($fileArr, 'game', $subFolder, $altName);
                $headerImg = new Image($headerName, 'Header image for ' . $altName . ' review');
                $review->setHeaderImg($headerImg);
                return;
            case 'gallery':
                $gallery = array();
                foreach ($fileArr as $key => $file) {
                    $galleryName = $this->getFileHandler()->addImgFile($file, 'game', $subFolder . '/gallery/', $altName . '_gallery');
                    $galImg = new Image($galleryName, 'Gallery image for the ' . $altName . ' review');
                    $gallery[$key] = $galImg;
                }
                $review->setGallery($gallery);
                return;
            case 'gallerySingle':
                $galleryName = $this->getFileHandler()->addImgFile($fileArr, 'game', $subFolder . '/gallery/', $altName . '_gallery');
                return new Image($galleryName, 'Gallery image for the ' . $altName . ' review');
        }
    }

    public function addToReview($type, $reviewId, $param1, $param2 = NULL) {
        $review = $this->get($reviewId, 'review');
        switch ($type) {
            case 'gallery':
                $img = $this->addImgtoReview('gallerySingle', $review, $param1);
                $this->getReviewService()->addGalleryImageToReview($review->getId(), $img);
                return;
            case 'good':
                $this->getReviewService()->addGood($review->getId(), $param1);
                return;
            case 'bad':
                $this->getReviewService()->addBadd($review->getId(), $param1);
                return;
            case 'tag':
                $this->getReviewService()->addTag($review->getId(), $param1);
                return;
            case 'rootComment':
                $this->getReviewService()->addRootComment($review, $param1);
                return;
            case 'userScore':
                $this->getReviewService()->addUserScore($review->getId(), $param1, $param2);
                $review->addUserScore($param1, $param2);
                return $review->getAverageUserScore();
            case 'gameGenre':
                $this->getReviewService()->addGenreToGame($review->getGame()->getId(), $param1);
                return;
            case 'gamePlatform':
                $this->getReviewService()->addPlatformToGame($review->getGame()->getId(), $param1);
                return;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function addToUser(UserDetailed $user, DaoObject $daoObj, $type) {
        switch ($type) {
            case 'notification':
                $this->_userService->addNotification($user, $daoObj);
                return $user;
            case 'achievement' :
                $this->_userService->addAchievement($user, $daoObj);
                return $user;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function updateUser(UserSimple $user, $type, $param1 = '', $param2 = '') {
        switch ($type) {
            case 'pw':
                $this->getUserService()->updatePw($user, $param1, $param2);
                return $user;
            case 'userRole':
                $this->getUserService()->updateUserUserRole($user, $param1);
                return $user;
            case 'avatar':
                $this->getUserService()->updateUserAvatar($user, $param1);
                return $user;
            case 'donated':
                $this->getUserService()->updateUserDonated($user, $param1);
                return $user;
            case 'karma':
                $this->getUserService()->updateUserKarma($user, $param1);
                return $user;
            case 'regKey':
                $this->getUserService()->updateUserRegKey($user, $param1);
                return $user;
            case 'warning':
                $this->getUserService()->updateUserWarnings($user);
                return $user;
            case 'diamond':
                $this->getUserService()->updateUserDiamonds($user, $param1, $param2);
                return $user;
            case 'dateTimePref':
                $this->getUserService()->updateUserDateTimePref($user, $param1);
                return $user;
            case 'lastLogin':
                $this->getUserService()->updateUserLastLogin($user, $param1, $param2);
                return $user;
            case 'activeTime':
                $this->getUserService()->updateUserActiveTime($user, $param1);
                return $user;
            case 'notification':
                $this->getUserService()->updateNotification($user, $param1, $param2);
                return $user;
            case 'avatarCustom':
                $addIt = $this->add($param1, 'avatar', $param2);
                $avatar = $this->getByIdentifier($addIt->getImage()->getUrl(), 'avatar');
                $this->updateUser($user, 'avatar', $avatar);
                return;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function updateComment(Comment $comment, $type, $param1) {
        switch ($type) {
            case 'body':
                $this->getCommentService()->updateCommentText($comment->getId(), $param1);
                return;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function updateNewsfeed(NewsfeedItem $newsfeedItem, $type, $param1) {
        switch ($type) {
            case 'subject' :
                $this->getNewsfeedService()->updateNewsfeedItemSubject($newsfeedItem->getId(), $param1);
                return;
            case 'body' :
                $this->getNewsfeedService()->updateNewsfeedItemBody($newsfeedItem->getId(), $param1);
                return;
            case 'image' :
                $this->getFileHandler()->removeFile(Globals::getRoot('view', 'app') . 'images/newsfeeds/' . $newsfeedItem->getImage()->getUrl());
                $this->addNewsfeedImg($newsfeedItem, $param1);
                $this->_generalDistDB->updateImgUrl($newsfeedItem->getImage()->getUrl(), $newsfeedItem->getImage()->getUrl());
            case 'body' :
        }
    }

    public function updateReview(Review $review, $type, $fileArr = NULL) {
        $baseUrl = Globals::getGameHeaderRoot($review->getGame()->getName()) . Globals::cleanStringUnderScore($review->getHeaderImg()->getUrl());
        $urlPrev = $review->getHeaderImg()->getUrl();
        switch ($type) {
            case 'core':
                $this->getReviewService()->updateReview($review);
                return;
            case 'header':
                $this->getFileHandler()->removeFile($baseUrl);
                $this->addImgtoReview($type, $review, $fileArr);
                $this->_generalDistDB->updateImgUrl($urlPrev, $review->getHeaderImg()->getUrl());
                return;
            case 'game':
                $this->getReviewService()->updateGameCore($review->getGame());
                return;
        }
    }

    public function removeFromUser(UserDetailed $user, $id, $type) {
        switch ($type) {
            case 'notification':
                $this->getUserService()->removeNotification($user, $id);
                return $user;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function removeFromReview(Review $review, $type, $param1) {
        switch ($type) {
            case 'gallery' :
                $this->getReviewService()->removeGalleryImage($review->getId(), $param1, TRUE);
                $name = $this->getFileHandler()->cleanWhiteSpace($review->getGame()->getName());
                $url = 'application/view/images/games/' . $name . '/' . $review->getGallery()[$param1]->getUrl();
                $this->getFileHandler()->removeFile($url);
                return;
            case 'good' :
                $this->getReviewService()->removeGood($review->getId(), $param1);
                return;
            case 'bad' :
                $this->getReviewService()->removeBad($review->getId(), $param1);
                return;
            case 'tag':
                $this->getReviewService()->removeTag($review->getId(), $param1);
                return;
            case 'comment':
                $this->getReviewService()->removeRootcomment($review, $param1);
                return;
            case 'userScore':
                $this->getReviewService()->removeUserScore($review->getId(), $param1);
                return;
            case 'genre':
                $this->getReviewService()->removeGenreFromGame($review->getGame()->getId(), $param1);
                return;
            case 'platform' :
                $this->getReviewService()->removePlatformFromGame($review->getGame()->getId(), $param1);
                return;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function checkAvailability($identifier, $type) {
        switch ($type) {
            case 'email' :
                return $this->getUserService()->checkEmailAvailable($identifier);
            case 'username' :
                return $this->getUserService()->checkUsernameAvailable($identifier);
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function getCleanFilesArray($files) {
        $reArrayed = $this->getFileHandler()->reArrayFiles($files);
        $cleaned = $this->getFileHandler()->removeEmptyFiles($reArrayed);
        return $cleaned;
    }

    private function typeNotRecognized($type) {
        throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
    }

    private function addAvatarPic($tier, $extra) {
        $subFolder = '';
        if (!is_numeric($extra[1])) {
            $subFolder = 'users/' . $extra[1] . '/';
        } else {
            $subFolder = 'tier' . $tier . '/';
        }
        $url = $subFolder . $this->getFileHandler()->addImgFile($extra[0], 'avatar', $subFolder, $extra[1]);
        return $url;
    }

    private function addNewsfeedImg(NewsfeedItem $newsfeedItem, $extra) {
        $name = $this->getFileHandler()->cleanWhiteSpace($newsfeedItem->getSubject());
        $url = $this->getFileHandler()->addImgFile($extra, 'newsfeed', '', $name);
        $img = new Image($url, 'Newsfeed image for ' . $newsfeedItem->getSubject());
        $newsfeedItem->setImage($img);
        return $url;
    }

}
