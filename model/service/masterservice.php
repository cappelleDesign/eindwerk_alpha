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

    //TODO other services

    public function __construct($configs) {
        $this->init($configs);
    }

    private function init($configs) {
        $this->_daoFactory = new DaoFactory();
        $userDB = $this->_daoFactory->getUserDB($configs);
        $this->_userService = new UserService($userDB);
        //TODO add other services init
        $this->createMenus();
        $this->_imgHelper = new imageHelper();
    }

    private function createMenus() {
        $this->createMainMenu();
        $this->createAdminMenu();
        $this->createProfileMenu();
    }

    private function createMainMenu() {
        $menuHome = new MenuItem('home', 'Home', 'home.php');
        $menuReview = new MenuItem('reviews', 'Reviews', 'reviews.php');
        $subMenuVideo1 = new MenuItem('liveStream', 'Live', 'livestream.php');
        $subMenuVideo2 = new MenuItem('streams', 'Lets plays', 'streams.php');
        $subMenuVideo3 = new MenuItem('podcasts', 'Podcasts', 'podcasts.php');
        $subMenuVideo = array($subMenuVideo1, $subMenuVideo2, $subMenuVideo3);
        $menuVideo = new MenuItem('videos', 'Video', 'video', $subMenuVideo);
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
