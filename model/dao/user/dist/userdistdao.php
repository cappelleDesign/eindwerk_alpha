<?php

/**
 * UserDistDao
 * This is an interface for all classes that handle user dist database functionality
 * @package dao
 * @subpackage dao.user.dist
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface UserDistDao {

    /**
     * updateUserAvatar
     * Updates the avatar for the user with this id
     * @param int $userId
     * @param int $avatarId
     */
    public function updateUserAvatar($userId, $avatarId);

    /**
     * getAchievements
     * Returns all the achievements
     * @return array $achievements
     */
    public function getAchievements($userId);

    /**
     * getAchievement
     * Returns the achievement with this name
     * @param string $name
     */
    public function getAchievement($name);
    
    /**
     * addAchievementToUser
     * Adds an achievement to the user with this id
     * @param int $userId
     * @param int $achievementId
     */
    public function addAchievementToUser($userId, $achievementId);

    /**
     * getAvatar
     * Returns the avatar with this id
     * @param int $avatarId
     * @return Avatar $avatar
     */
    public function getAvatar($avatarId);

    /**
     * updateUserUserRole
     * Updates the user role for the user with this id
     * @param int $userId
     * @param int $userRoleId
     */
    public function updateUserUserRole($userId, $userRoleId);

    /**
     * getUserRole
     * Returns the user role with this id
     * @param int $flag
     * @return UserRole $userRole
     */
    public function getUserRole($flag);

    /**
     * getLastComment
     * Returns the last comment for the user with this id
     * @param UserSimple $simpleUser
     * @return Comment $lastComment
     */
    public function getLastComment(UserSimple $simpleUser);

    /**
     * getAllAchievements
     *  Returns all the achievements
     *  @return array $achievements
     */
    public function getAllAchievements();

    /**
     * getUserRoles
     * Returns all the user roles
     * @return array $userRoles
     */
    public function getUserRoles();

    /**
     * getAvatars
     * Returns all the avatars
     * @return array $avatars
     */
    public function getAvatars();
}
