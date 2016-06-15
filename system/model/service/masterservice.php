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

    public function add(DaoObject $daoObj, $type) {
        switch ($type) {
            case 'user':
                $this->getUserService()->addUser($daoObj);
                return $daoObj;
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function remove($daoId, $type) {
        switch ($type) {
            case 'user':
                $this->getUserService()->removeUser($daoId);
                return true;
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
            case 'avatar' :
                return $this->getUserService()->getAvatar($id);
            default :
                $this->typeNotRecognized($type);
        }
    }

    public function getAll($type) {
        switch ($type) {
            case 'users' :
                return $this->getUserService()->getUsers();
            case 'avatars' :
                return $this->getUserService()->getAvatars();
            case 'userRoles' :
                return $this->getUserService()->getUserRoles();
            case 'achievements' :
                return $this->getUserService()->getAllAchievements();
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
                    return $this->getUserService()->getUserRole($identifier);
                case 'achievement' :
                    return $this->getUserService()->getAchievement($identifier);
                default :
                    $this->typeNotRecognized($type);
            }
        } catch (Exception $ex) {
            throw new ServiceException($ex);
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

    public function updateUser(UserDetailed $user, $type, $param1 = '', $param2 = '') {
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
            default :
                $this->typeNotRecognized($type);
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

    private function typeNotRecognized($type) {
        throw new ServiceException('Type \'' . $type . '\' not recognized', NULL);
    }

}
