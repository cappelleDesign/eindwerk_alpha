<?php

interface ImgDao extends Dao{
    public function updateUserAvatar($userId, $avatarId);
    
    public function getAchievements($userId);    

    public function addAchievement($userId, $achievementId);

    public function getAvatar($avatarId);
}
