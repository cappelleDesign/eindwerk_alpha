<?php

interface NotificationDao {

    public function containsId($id, $instance);
    
    public function addNotification($userId, Notification $notification);

    public function updateNotification($notificationId, $isRead);

    public function removeNotification($notificationId);

    public function getNotifications($userId, $limit);
}
