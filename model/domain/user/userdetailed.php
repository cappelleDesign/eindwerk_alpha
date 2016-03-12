<?php

/**
 * UserDetailed
 * Extends simple user for more detailed information of a user
 * @package model
 * @subpackage domain.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserDetailed extends UserSimple {

    /**
     * Encrypted password of the user
     * @var string 
     */
    private $_pwEncrypted;

    /**
     * Email to reach user
     * @var string 
     */
    private $_email;

    /**
     * Number of karma points the user has acquired
     * @var int 
     */
    private $_karma;

    /**
     * Regkey of pw reset and registration purpose
     * @var string 
     */
    private $_regKey;

    /**
     * Number of warnings a user already had
     * @var int 
     */
    private $_warnings;

    /**
     * Number of diamonds a user has acquired
     * @var string 
     */
    private $_diamonds;

    /**
     * Date format preference for this user
     * @var string
     */
    private $_dateTimePref;

    /**
     * Date and time when user was created
     * @var DateTime  
     */
    private $_created;

    /**
     * Date and time of last login
     * @var DateTime 
     */
    private $_lastLogin;

    /**
     * Keeps track of the total online time of this user (estimated) in seconds
     * @var int 
     */
    private $_activeTime;

    /**
     *  Keeps track of the last comment (for checking when to comment again etc.)
     * @var Comment
     */
    private $_lastComment;

    /**
     * Last x notifications a user had
     * Associative array <notificationId,notification>
     * @var array 
     */
    private $_recentNotifications;

    /**
     * Achievements rewarded to this user
     * Associative array achievements[achievementId] = achievement)
     * @var array
     */
    private $_achievements;

    public function __construct(UserRole $userRole, Avatar $avatar, $username, $donated, $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime, Comment $lastComment, $recentNotifications, $achievements, $dateFormat) {
        parent::__construct($userRole, $avatar, $username, $donated);
        $this->init();
        $this->setPwEncrypted($pwEncrypted);
        $this->setEmail($email);
        $this->setKarma($karma);
        $this->setRegKey($regKey);
        $this->setWarnings($warnings);
        $this->setDiamonds($diamonds);
        $this->setDateTimePref($dateTimePref);
        $this->setCreated($created, $dateFormat);
        $this->setLastLogin($lastLogin, $dateFormat);
        $this->setActiveTime($activeTime);
        $this->setLastComment($lastComment);
        $this->setRecentNotifications($recentNotifications);
        $this->setAchievements($achievements);
    }

    private function init() {
        $this->_recentNotifications = [];
        $this->_achievements = [];
    }

    /* ---------------------------------------------------------------------- */

    public function setPwEncrypted($pwEncrypted) {
        $this->_pwEncrypted = $pwEncrypted;
    }

    public function setEmail($email) {
        $this->_email = $email;
    }

    public function setKarma($karma) {
        $this->_karma = $karma;
    }

    public function setRegKey($regKey) {
        $this->_regKey = $regKey;
    }

    public function setWarnings($warnings) {
        $this->_warnings = $warnings;
    }

    public function setDiamonds($diamonds) {
        $this->_diamonds = $diamonds;
    }

    public function setDateTimePref($dateTimePref) {
        $this->_dateTimePref = $dateTimePref;
    }

    public function setCreated($created, $dateFormat) {
        $date = DateTime::createFromFormat($dateFormat, $created);
        $this->_created = $date;
    }

    public function setLastLogin($lastLogin, $dateFormat) {
        $date = DateTime::createFromFormat($dateFormat, $lastLogin);
        $this->_lastLogin = $date;
    }

    public function setActiveTime($activeTime) {
        $this->_activeTime = $activeTime;
    }

    public function setLastComment(Comment $lastComment) {
        $this->_lastComment = $lastComment;
    }

    public function setRecentNotifications($recentNotifications) {
        $this->_recentNotifications = $recentNotifications;
    }

    public function setAchievements($achievements) {
        $this->_achievements = $achievements;
    }

    /* ---------------------------------------------------------------------- */

    public function getPwEncrypted() {
        return $this->_pwEncrypted;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getKarma() {
        return $this->_karma;
    }

    public function getRegKey() {
        return $this->_regKey;
    }

    public function getWarnings() {
        return $this->_warnings;
    }

    public function getDiamonds() {
        return $this->_diamonds;
    }

    public function getDateTimePref() {
        return $this->_dateTimePref;
    }

    public function getCreated() {
        return $this->_created;
    }

    public function getLastLogin() {
        return $this->_lastLogin;
    }

    public function getActiveTime() {
        return $this->_activeTime;
    }

    public function getLastComment() {
        return $this->_lastComment;
    }

    public function getRecentNotifications() {
        return $this->_recentNotifications;
    }

    public function getAchievements() {
        return $this->_achievements;
    }

    /**
     * getLastLoginStr
     * returns the last login as string with given format.
     * format should be a php datetime format string.
     * @param string $format
     * @return string
     */
    public function getLastLoginStr($format) {
        return $this->_lastLogin->format($format);
    }

    /**
     * getCreatedStr
     * returns the creation date as string with given format.
     * format should be a php datetime format string.
     * @param string $format
     * @return string
     */
    public function getCreatedStr($format) {
        return $this->_created->format($format);
    }

    /**
     * updateKarma
     * adds/substracts amount to/from karma
     * @param int $amount
     */
    public function updateKarma($amount) {
        $this->_karma += $amount;
    }

    /**
     * updateDiamonds
     * adds/substracts amount to/from diamonds and adds/substracts bonus karma
     * @param int $amount
     * @param int $karmaBonus
     */
    public function updateDiamonds($amount, $karmaBonus) {
        $this->_diamonds += $amount;
        $this->updateKarma($karmaBonus);
    }

    /**
     * addWarning
     * adds a warning
     */
    public function addWarning() {
        $this->_warnings++;
    }

    /**
     * authenticate
     * checkes if correct password
     */
    public function authenticate($pwString) {
        return Authenticator::authenticate($pwString, $this->_pwEncrypted);
    }

    /**
     * addNewRecentNofitification
     * Adds a notification to the latest notifications and removes the oldest one
     * @param Notification $notification
     */
    public function addNewRecentNotification(Notification $notification) {
        $length = count($this->_recentNotifications);
        if ($length >= 10) {
            $oldest = $this->getOldestNotification()->getId();
            $this->removeRecentNotification($oldest);
        }
        $this->_recentNotifications[$notification->getId()] = $notification;
    }

    /**
     * Helper function to search and return the oldest notification's id
     * @return int
     */
    private function getOldestNotification() {
        $notif = $this->getRecentNotifications();
        usort($notif, "notifSortOldFirst");
        return $notif[0];
    }

    /**
     * Helper function to sort the notifications from oldest to newest
     * @param Notification $a
     * @param Notification $b
     * @return int
     */
    function notifSortOldFirst($a, $b) {
        return $a->getDateTime() > $b->getDateTime();
    }

    /**
     * Helper function to sort the notifications from newest to oldest
     * @param Notification $a
     * @param Notification $b
     * @return int
     */
    function notifSortNewFirst($a, $b) {
        return $a->getDateTime() < $b->getDateTime();
    }

    /**
     * Function to remove a notification
     * @param int $notificationId
     */
    public function removeRecentNotification($notificationId) {
        if (array_key_exists($notificationId, $this->getRecentNotifications())) {
            unset($this->getRecentNotifications()[$notificationId]);
        }
    }

    /**
     * Adds x seconds to the active time
     * @param int $time
     */
    public function updateActiveTime($time) {
        $this->_activeTime += $time;
    }

    /**
     * getLastCommented
     * returns the datetime of this users last comment
     * @return DateTime
     */
    public function getLastCommented() {
        return $this->getLastComment()->getCreated();
    }

    /**
     * Adds a new achievement to this user
     * @param Achievement $achievement
     */
    public function addAchievement(Achievement $achievement) {
        $this->_achievements[$achievement->getId()] = $achievement;
        $this->updateDiamonds($achievement->getDiamondReward(), $achievement->getKarmaReward());
    }

}
