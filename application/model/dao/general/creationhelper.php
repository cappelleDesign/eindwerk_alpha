<?php

/**
 * CreationHelper
 * This is a helper(factory) class to create objects from sql rows
 * @package dao
 * @subpackage dao.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class CreationHelper {

    /**
     * * createUserSimple
     * Creates a UserSimple object from an SQL row, 
     *  an Avatar object and a UserRole object.     
     * @param array $row
     * @param boolrean $detailed
     * @param Avatar $avatar
     * @param UserRole $userRole
     * @return UserSimple (or UserDetailed if $detailed flag is true)
     * @throws DBException
     */
    public function createUserSimple($row, Avatar $avatar, UserRole $userRole) {
        if (!$row) {
            throw new DBException('could not create user. Row was missing', NULL);
        }
        if (!$avatar) {
            throw new DBException('could not create user. Avatar was missing', NULL);
        }
        if (!$userRole) {
            throw new DBException('could not create user. User role was missing', NULL);
        }
        try {
            $id = $row['user_id'];
            $simpleUser = new UserSimple($userRole, $avatar, $row['user_name'], $row['donated_amount']);
            $simpleUser->setId($id);
            return $simpleUser;
        } catch (Exception $ex) {
            throw new DBException($ex);
        }
    }

    /**
     * * createDetailedUser
     * Creates a UserDetailed object from a UserSimple,an SQL row, 
     *  $recentNotifications, $lastComment and $achievements.
     * @param UserSimple $simpleUser
     * @param array $row   
     * @param type $recentNotifications
     * @param type $lastComment
     * @param type $achievements
     * @return UserDetailed
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
            throw new DBException($ex);
        }
    }

    /**
     * createComment
     * Creates a comment object from an SQL row, a UserSimple and a voters array
     * @param array $row
     * @param UserSimple $poster
     * @param array $voters
     * @return Comment
     */
    public function createComment($row, UserSimple $poster, $voters) {
        if (!$row || !$poster) {
            throw new DBException('could not create last comment', NULL);
        }
        try {
            $comment = new Comment($row['parent_id'], $row['parent_root_id'],$poster, $row['commented_on_notif_id'], $row['comment_txt'], $row['comment_created'], $voters, Globals::getDateTimeFormat('mysql', true));
            $comment->setId($row['comment_id']);
            return $comment;
        } catch (Exception $ex) {
            throw new DBException($ex);
        }
    }

    /**
     * createNotification
     * Creates a notification object from an SQL row
     * @param array $row
     * @return Notification
     * @throws DBException
     */
    public function createNotification($row, $format) {
        if (!$row) {
            throw new DBException('could not create notification', NULL);
        }
        $notif = new Notification($row['user_id'], $row['notification_txt'], $row['notification_link'], $row['notification_date'], $row['notification_isread'], $format);
        $notif->setId($row['notification_id']);
        return $notif;
    }

    /**
     * crateAvatar
     * Creates an Avatar object from an SQL row and an image
     * @param array $row
     * @param Image $image
     * @return Avatar
     */
    public function createAvatar($row, Image $image) {
        try {
            $avatar = new Avatar($image, $row['tier']);
            $avatar->setId($row['avatar_id']);
            return $avatar;
        } catch (Exception $ex) {
            throw new DBException($ex);
        }
    }

    /**
     * createAchievement
     * Creates an Achievement object from an SQL row and an Image object
     * @param array $row
     * @param Image $image
     * @return Achievement
     */
    public function createAchievement($row, Image $image) {
        try {
            $achievement = new Achievement($image, $row['name'], $row['desc'], $row['karma_award'], $row['diamond_award']);
            $achievement->setId($row['achievement_id']);
            return $achievement;
        } catch (Exception $ex) {
            throw new DBException($ex);
        }
    }

    /**
     * createUserRole
     * Creates a UserRole object from an SQL row
     * @param array $row
     * @return UserRole
     */
    public function createUserRole($row) {
        try {
            $userRole = new UserRole($row['user_role_name'], $row['user_role_access_flag'], $row['user_role_karma_min'], $row['user_role_diamond_min']);
            $userRole->setId($row['user_role_id']);
            return $userRole;
        } catch (Exception $ex) {
            Throw new DBException($ex);
        }
    }

    public function createVote($row) {
        try {
            $vote = new Vote($row['user_id'], $row['comment_id'], $row['voted_on_notif_id'], $row['user_name'], $row['vote_flag']);
            return $vote;
        } catch (Exception $ex) {
            throw new DBException($ex);
        }
    }

}
