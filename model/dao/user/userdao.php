<?php

/**
 * DaoObject
 * This is an interface for all classes that handle user database functionality
 * @package dao
 * @subpackage dao.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface UserDao extends Dao {

    /**
     * emailAvailable
     * Checks if this email address is available
     * @param string $mail
     * @return boolean $available
     */
    public function emailAvailable($mail);

    /**
     * usernameAvailable
     * Checks if this username is available
     * @param string $username
     * @returns boolean $available
     */
    public function usernameAvailable($username);

    /**
     * getUsers
     * Returns all users as UserSimple objects in an array
     * @return array $users
     */
    public function getUsers();

    /**
     * getSimple
     * Returns a UserSimple object if the id matches
     * @param int $user_id
     * @return UserSimple $user
     */
    public function getSimple($user_id);

    /**
     * updatePw
     * Updates the password for the user with this id
     * @param int $userId
     * @param string $pwNew
     */
    public function updatePw($userId, $pwNew);

    /**
     * updateUserUserRole
     * Updates the user role for the user with this id
     * @param int $userId
     * @param int $userRoleId
     */
    public function updateUserUserRole($userId, $userRoleId);

    /**
     * updateUserAvatar
     * Updates the avatar for the user with this id
     * @param int $userId
     * @param int $avatarId
     */
    public function updateUserAvatar($userId, $avatarId);

    /**
     * updateUserDonated
     * Updates the donated amount for the user with this id
     * @param int $userId
     * @param int $donated
     */
    public function updateUserDonated($userId, $donated);

    /**
     * updateUserKarma
     * Updates the karma for the user with this id
     * @param int $userId
     * @param int $newAmount
     */
    public function updateUserKarma($userId, $newAmount);

    /**
     * updateUserRegKey
     * Updates the reg key for the user with this id
     * @param int $userId
     * @param String $regKey
     */
    public function updateUserRegKey($userId, $regKey);

    /**
     * updateUserWarnings
     * Updates the number of warnings for the user with this id
     * @param int $userId
     * @param int $warnings
     */
    public function updateUserWarnings($userId, $warnings);

    /**
     * updateUserDiamonds
     * Updates the number of diamonds for the user with this id
     * @param int $userId
     * @param int $diamonds
     */
    public function updateUserDiamonds($userId, $diamonds);

    /**
     * updateUserDatetimePref
     * Updates the Date and time preference for the user with this id
     * @param int $userId
     * @param string $dateTimePref
     */
    public function updateUserDateTimePref($userId, $dateTimePref);

    /**
     * updateUserLastLogin
     * Updates the last login date for the user with this id
     * @param int $userId
     * @param DateTime $lastLogin
     */
    public function updateUserLastLogin($userId, DateTime $lastLogin);

    /**
     * updateUserActiveTime
     * Updates the total active time for the user with this id
     * @param int $userId
     * @param int $activeTime (in s)
     */
    public function updateUserActiveTime($userId, $activeTime);

    /**
     * addNotification
     * Adds a notification to the user with this id
     * @param int $userId
     * @param Notification $notification
     */
    public function addNotification($userId, Notification $notification);

    /**
     * updateNotification
     * Updates the Notification with this id
     * @param int $notificationId
     * @param boolean $isRead
     */
    public function updateNotification($notificationId, $isRead);

    /**
     * removeNotification
     * Removes the notification with this id from the database
     * @param type $notificationId
     */
    public function removeNotification($notificationId);

    /**
     * addAchievement
     * Adds an achievement to the user with this id
     * @param int $userId
     * @param int $achievementId
     */
    public function addAchievement($userId, $achievementId);

    /**
     * getUserRole
     * Returns the user role with this id
     * @param type $userRoleId
     * @return UserRole $userRole
     */
    public function getUserRole($userRoleId);

    /**
     * getAvatar
     * Returns the avatar with this id
     * @param type $avatarId
     * @return Avatar $avatar
     */
    public function getAvatar($avatarId);

    /**
     * getAvatars
     * Returns all the avatars
     * @return array $avatars
     */
    public function getAvatars();

    /**
     * getUserRoles
     * returns all the user roles
     * @return array $userRoles
     */
    public function getUserRoles();

    /**
     * getAchievements
     * Returns all the achievements
     * @return array $achievements
     */
    public function getAllAchievements();
    
    /**
     * getAchievement
     * Returns the achievement if the name matches
     * @param string $name
     * @return Achievement $achievement
     */
    public function getAchievement($name);
}
