<?php

/**
 * DaoObject
 * This is an interface for all classes that handle user database functionality
 * @package dao
 * @subpackage dao.user
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface UserDao extends Dao{
    
    public function emailAvailable($mail);
    
    public function usernameAvailable($username);

    /**
     * getUsers
     * returns all users as UserSimple.class in an array
     * @return array $users
     */
    public function getUsers();

    public function getSimple($user_id);

    public function updatePw($userId, $pwNew);

    public function updateUserUserRole($userId, $userRoleId);

    public function updateUserAvatar($userId, $avatarId);

    //FIXME allow this?
//    public function updateUserName($userId, $username);

    public function updateUserDonated($userId, $donated);

    public function updateUserKarma($userId, $newAmount);

    public function updateUserRegKey($userId, $regKey);

    public function updateUserWarnings($userId, $warnings);

    public function updateUserDiamonds($userId, $diamonds);

    public function updateUserDateTimePref($userId, $dateTimePref);

    public function updateUserLastLogin($userId, DateTime $lastLogin);

    public function updateUserActiveTime($userId, $activeTime);

//    public function updateUserLastComment($userId, $commentId);

    public function addNotification($userId, Notification $notification);

    public function updateNotification($notificationId, $isRead);

    public function removeNotification($notificationId);

    public function getNotifications($userId, $limit);

    public function addAchievement($userId, $achievementId);
}
