<?php

/**
 * NewsfeedService
 * This is a class that handles newsfeed service functions
 * @package service
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
class NewsfeedService {

    /**
     * The newsfeed database
     * @var NewsfeedDao
     */
    private $_newsfeedDB;

    public function __construct($newsfeedDB) {
        $this->init($newsfeedDB);
    }

    private function init($newsfeedDB) {
        $this->_newsfeedDB = $newsfeedDB;
    }

    /**
     * addNewsfeedItem
     * Adds a newsfeed item to the database
     * @param NewsfeedItem $newsfeedItem
     * @return int $id
     * @throws ServiceException
     */
    public function addNewsfeedItem(NewsfeedItem $newsfeedItem) {
        try {
            $this->_newsfeedDB->add($newsfeedItem);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getNewsfeedItem
     * Returns the newsfeed item with this id
     * @param int $newsfeedItemId
     * @return NewsfeedItem
     * @throws ServiceException
     */
    public function getNewsfeedItem($newsfeedItemId) {
        try {
            $newsfeedItem = $this->_newsfeedDB->get($newsfeedItemId);
            return $newsfeedItem;
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * getNewsfeed
     * Returns all newsfeed items with these options.
     * possible options: string subject, string body, int limit
     * @param array $options      
     * @return NewsfeedItem[]
     * @throws ServiceException
     */
    public function getNewsfeed($options = array()) {
        try {
            $newsfeed = $this->_newsfeedDB->getNewsfeed($options);
            return $newsfeed;
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateNewsfeedItemSubject
     * Updates the subject of the newsfeed item
     * @param int $newsfeedItemId
     * @param string $subject
     * @throws ServiceException
     */
    public function updateNewsfeedItemSubject($newsfeedItemId, $subject) {
        try {
            $this->_newsfeedDB->updateNewsfeedItemSubject($newsfeedItemId, $subject);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateNewsfeedItemBody
     * Updates the body of the newsfeed item
     * @param int $newsfeedItemId
     * @param string $body
     * @throws ServiceException
     */
    public function updateNewsfeedItemBody($newsfeedItemId, $body) {
        try {
            $this->_newsfeedDB->updateNewsfeedItemBody($newsfeedItemId, $body);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * updateNewsfeedItemImage
     * Updates the image linked to the newsfeed item
     * @param int $newsfeedItemId
     * @param Image $image
     * @throws ServiceException
     */
    public function updateNewsfeedItemImage($newsfeedItemId, $image) {
        try {
            $this->_newsfeedDB->updateNewsfeedItemImage($newsfeedItemId, $image);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

    /**
     * remove
     * Removes the newsfeed item with this id from the database
     * @param int $newsfeedItemId
     * @throws ServiceException
     */
    public function removeNewsfeedItem($newsfeedItemId) {
        try {
            $this->_newsfeedDB->remove($newsfeedItemId);
        } catch (Exception $ex) {
            throw new ServiceException($ex->getMessage(), $ex);
        }
    }

}
