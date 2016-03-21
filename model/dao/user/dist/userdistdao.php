<?php

interface UserDistDao {
    
    public function containsId($id, $instance);

    public function updateUserAvatar($userId, $avatarId);

    public function getAchievements($userId);

    public function addAchievement($userId, $achievementId);

    public function getAvatar($avatarId);

    public function updateUserUserRole($userId, $userRoleId);

    public function getUserRole($userRoleId);
}
