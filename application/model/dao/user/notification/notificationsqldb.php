<?php

/**
 * NotificationSqlDB
 * This is a class that handles user notification SQL database functions
 * @package dao
 * @subpackage dao.user.notification
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class NotificationSqlDB extends SqlSuper implements NotificationDao {

    public function __construct($connection) {
        parent::__construct($connection);
    }

    /**
     * addNotification
     * Adds a notification to the user with this id
     * @param int $userId
     * @param Notification $notification
     * @return int the id of the newly added notification
     * @throws DBException
     */
    public function addNotification($userId, Notification $notification) {
        parent::triggerIdNotFound($userId, 'user');
        if (parent::containsId($notification->getId(), 'notification')) {
            throw new DBException('Notification with id ' . $notification->getId() . ' already exists', NULL);
        }
        $notifT = Globals::getTableName('notification');
        $query = 'INSERT INTO ' . $notifT . ' (`user_id`, `notification_txt`, notification_link,`notification_date`, `notification_isread`) ' .
                'VALUES (:userId, :message, :link,:time, :read);';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':userId' => $userId,
            ':message' => $notification->getText(),
            ':link' => $notification->getLink(),
            ':time' => $notification->getCreatedStr(Globals::getDateTimeFormat('mysql', TRUE)),
            ':read' => '0'
        );
        $statement->execute($queryArgs);
        return parent::getLastId();
    }

    /**
     * updateNotification
     * Updates the notification to is read true for user with id
     * @param string $text
     * @param boolean $isRead
     * @throws DBException
     */
    public function updateNotification($notificationId, $text, $isRead = FALSE, $link = NULL) {
        parent::triggerIdNotFound($notificationId, 'notification');
        $notifT = Globals::getTableName('notification');
        $queryArgs = array(
            ':read' => $isRead,
            ':txt' => $text,
            ':notifId' => $notificationId
        );
        $linkPart = '';
        if ($link) {
            $linkPart = $notifT . '.notification_link = :link,';
            $queryArgs[':link'] = $link;
        }
        $query = 'UPDATE ' . $notifT . ' SET ' . $notifT . '.notification_txt = :txt,' . $linkPart . $notifT . '.notification_isread = :read WHERE ' . $notifT . '.notification_id = :notifId';
        $statement = parent::prepareStatement($query);
        $statement->execute($queryArgs);        
    }

    /**
     * removeNotification
     * Removes the notificaion with this id
     * @param int $notificationId
     * @throws DBException
     */
    public function removeNotification($notificationId) {
        parent::triggerIdNotFound($notificationId, 'notification');
        $notifT = Globals::getTableName('notification');
        $query = 'DELETE FROM ' . $notifT . ' WHERE ' . $notifT . '.notification_id = :notifId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':notifId' => $notificationId
        );
        $statement->execute($queryArgs);        
    }

    /**
     * getNotifications
     * returns all notifications for user with id
     * @param int $userId
     * @param int $limit
     * @return array of notifications
     */
    public function getNotifications($userId, $limit) {
        $query = 'SELECT * FROM ' . Globals::getTableName('notification') . '  WHERE user_id = ? AND notification_isread = 0 ORDER BY notifications.notification_date DESC LIMIT ?';
        $statement = parent::prepareStatement($query);
        $statement->bindParam(1, $userId);
        $statement->bindParam(2, $limit, PDO::PARAM_INT);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        $notifications = array();
        foreach ($result as $row) {
            try {
                $format = Globals::getDateTimeFormat('mysql', true);
                $notif = $this->createNotification($row, $format);
                $notifications[$notif->getId()] = $notif;
            } catch (DomainModelException $ex) {
                throw new DBException($ex->getMessage(), $ex);
            }
        }
        return $notifications;
    }

    /**
     * createNotification
     * Uses the CreationHelper to create a Notification object
     * @param array $row
     * @return Notification
     */
    private function createNotification($row, $format) {
        return parent::getCreationHelper()->createNotification($row, $format);
    }

}
