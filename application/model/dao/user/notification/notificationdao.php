<?php
/**
 * NotificationDao
 * This is an interface for all classes that handle user notification database functionality
 * @package dao
 * @subpackage dao.user.notification
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface NotificationDao {
    
    /**
     * addNotification
     * Adds a notification to the notification table and links it to the user by id
     * @param int $userId
     * @param Notification $notification
     */
    public function addNotification($userId, Notification $notification);

    /**
     * updateNotification
     * Updates the readed state of a notification if the id matches 
     * @param int $notificationId
     * @param int $text 
     * @param boolean $isRead
     */
    public function updateNotification($notificationId, $text, $isRead);

    /**
     * removeNotification
     * Removes the notification with this id
     * @param int $notificationId
     */
    public function removeNotification($notificationId);

    /**
     * getNotifications
     * Gets all the notifications for this user limitied by the limt param
     * @param int $userId
     * @param int $limit
     * @return array $notifications
     */
    public function getNotifications($userId, $limit);
}
