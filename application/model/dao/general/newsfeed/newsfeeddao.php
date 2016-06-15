<?php

/**
 * NewsfeedDao
 * This is an interface for all classes that handle newsfeed database functionality
 * @package dao
 * @subpackage dao.general.newsfeed
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface NewsfeedDao extends Dao {

    /**
     * getNewsfeed
     * Returns all newsfeed items with these options.
     * possible options: string subject, string body, int limit
     * @param array $options      
     * @return NewsfeedItem[]
     */
    public function getNewsfeed($options);

    /**
     * updateNewsfeedItemImage
     * Updates the image linked to the newsfeed item
     * @param int $newsfeedItemId
     * @param Image $image
     */
    public function updateNewsfeedItemImage($newsfeedItemId, Image $image);

    /**
     * updateNewsfeedItemSubject
     * Updates the subject of the newsfeed item
     * @param int $newsfeedItemId
     * @param string $subject
     */
    public function updateNewsfeedItemSubject($newsfeedItemId, $subject);

    /**
     * updateNewsfeedItemBody
     * Updates the body of the newsfeed item
     * @param int $newsfeedItemId
     * @param string $body
     */
    public function updateNewsfeedItemBody($newsfeedItemId, $body);
}
