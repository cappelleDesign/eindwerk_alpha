<?php

interface NotificationDao extends Dao{

    public function addNotification($userId, Notification $notification);

    public function updateNotification($notificationId, $isRead);

    public function removeNotification($notificationId);

    public function getNotifications($userId, $limit);
    
    public function createNotification($row);
}
