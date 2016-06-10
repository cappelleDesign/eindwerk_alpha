<?php

/**
 * UserCreationHelper
 * This is a helper(factory) class to create user related objects from sql rows
 * @package service
 * @subpackage service.creation
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class UserCreationHelper {

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
        if (!$row) {
            throw new ServiceException('could not create user. Row was missing', NULL);
        }
        if (!$avatar) {
            throw new ServiceException('could not create user. Avatar was missing', NULL);
        }
        if (!$userRole) {
            throw new ServiceException('could not create user. User role was missing', NULL);
        }
        try {
            $id = $row['user_id'];
            $simpleUser = new UserSimple($userRole, $avatar, $row['user_name'], $row['donated_amount']);
            $simpleUser->setId($id);
            return $simpleUser;
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
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
        $userId = $simpleUser->getId();
        $pwEncrypted = $row['user_hash_salt'];
        $email = $row['user_email'];
        $karma = $row['user_karma'];
        $regKey = $row['user_reg_key'];
        $warnings = $row['user_warnings'];
        $diamonds = $row['user_diamonds'];
        $dateTimePref = $row['preference_datetime_format'];
        $created = $row['user_created'];
        $lastLogin = $row['last_login'];
        $activeTime = $row['active_seconds'];
        try {
            $detailedUser = new UserDetailed($simpleUser->getUserRole(), $simpleUser->getAvatar(), $simpleUser->getUsername(), $simpleUser->getDonated(), $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime, $lastComment, $recentNotifications, $achievements, Globals::getDateTimeFormat('mysql', true));
            $detailedUser->setId($userId);
            return $detailedUser;
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * createNotification
     * Creates a notification object from an SQL row
     * @param array $row
     * @return Notification
     * @throws ServiceException
     */
    public function createNotification($row, $format) {
        if (!$row) {
            throw new ServiceException('could not create notification', NULL);
        }
        $notif = new Notification($row['user_id'], $row['notification_txt'], $row['notification_link'], $row['notification_date'], $row['notification_isread'], $format);
        $notif->setId($row['notification_id']);
        return $notif;
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
        try {
            $achievement = new Achievement($image, $row['name'], $row['desc'], $row['karma_award'], $row['diamond_award']);
            $achievement->setId($row['achievement_id']);
            return $achievement;
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
    }

    /**
     * createUserRole
     * Creates a UserRole object from an SQL row
     * @param array $row
     * @return UserRole
     * @throws ServiceException
     */
    public function createUserRole($row) {
        try {
            $userRole = new UserRole($row['user_role_name'], $row['user_role_access_flag'], $row['user_role_karma_min'], $row['user_role_diamond_min']);
            $userRole->setId($row['user_role_id']);
            return $userRole;
        } catch (Exception $ex) {
            Throw new ServiceException($ex);
        }
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
        try {
            $avatar = new Avatar($image, $row['tier']);
            $avatar->setId($row['avatar_id']);
            return $avatar;
        } catch (Exception $ex) {
            throw new ServiceException($ex);
        }
    }

}
