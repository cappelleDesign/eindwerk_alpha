<?php

abstract class NotificationSqlDB extends SqlSuper implements NotificationDao {

    public function __construct($host, $username, $passwd, $database) {
        parent::__construct($host, $username, $passwd, $database);
    }
    
    public function add(DaoObject $daoObject) {
        
    }

    public function containsId($id) {
        
    }

    public function get($id) {
        
    }

    public function getByString($identifier) {
        
    }

    public function remove($id) {
        
    }

        /**
     * addNotification
     * Adds a notification to the user with this id
     * @param int $userId
     * @param Notification $notification
     * @return int the id of the newly added notification
     */
    public function addNotification($userId, Notification $notification) {
        $notifT = Globals::getTableName('notification');
        $query = 'INSERT INTO ' . $notifT . ' (`user_id`, `notification_txt`, `notification_date`, `notification_isread`) ' .
                'VALUES (:userId, :message, :time, :read);';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':userId' => $userId,
            ':message' => $notification->getText(),
            ':time' => $notification->getCreatedStr(Globals::getDateTimeFormat('mysql', TRUE)),
            ':read' => '0'
        );
        $statement->execute($queryArgs);
        return parent::getLastId();
    }

    /**
     * updateNotification
     * Updates the notification to is read true for user with id
     * @param int $userId
     * @param int $notificationId
     * @param boolean $isRead
     */
    public function updateNotification($notificationId, $isRead) {
        $notifT = Globals::getTableName('notification');
        $query = 'UPDATE ' . $notifT . ' SET ' . $notifT . '.notification_isread = :read WHERE ' . $notifT . '.notification_id = :notifId';
        $statement = parent::prepareStatement($query);
        $queryArgs = array(
            ':read' => $isRead,
            ':notifId' => $notificationId
        );
        $statement->execute($queryArgs);
    }

    /**
     * removeNotification
     * Removes the notificaion with this id
     * @param type $notificationId
     */
    public function removeNotification($notificationId) {
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
                $notif = $this->createNotification($row);
                $notifications[$notif->getId()] = $notif;
            } catch (DomainModelException $ex) {
                throw new DBException($ex->getMessage(), $ex);
            }
        }
        return $notifications;
    }

    public function createNotification($row) {
        if (!$row) {
            throw new DBException('could not create notification', NULL);
        }
        $notif = new Notification($row['user_id'], $row['notification_txt'], $row['notification_date'], $row['notification_isread'], Globals::getDateTimeFormat('mysql', true));
        $notif->setId($row['notification_id']);
        return $notif;
    }

    protected function triggerIdNotFound($id) {
        if (!$this->containsId($id) || count($this->containsId($id)) < 1) {
            throw new DBException('Notification with id ' . $id . ' not found.', NULL);
        }
    }
}
