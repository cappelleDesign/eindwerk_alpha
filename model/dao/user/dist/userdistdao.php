<?php

interface UserDistDao {

    public function updateUserAvatar($userId, $avatarId);

    public function getAchievements($userId);

    public function addAchievementToUser($userId, $achievementId);

    public function getAvatar($avatarId);

    public function updateUserUserRole($userId, $userRoleId);

    public function getUserRole($userRoleId);

    public function getLastComment(UserSimple $simpleUser);
    
    public function getUserRoles();
    
    public function getAvatars($maxTier);
}
