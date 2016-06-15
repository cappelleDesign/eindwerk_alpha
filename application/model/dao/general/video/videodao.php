<?php

/**
 * VideoDao
 * This is an interface for all classes that handle video database functionality
 * @package dao
 * @subpackage dao.video
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
interface VideoDao extends Dao {

    /**
     * getVideos
     * Returns all videos with these options.
     * @param array $options
     * @return Video[]
     */
    public function getVideos($options);

    /**
     * updateVideo
     * Updates a video
     * @param Video $video
     */
    public function updateVideo(Video $video);

    /**
     * addRootComment
     * Adds a root comment to this video.
     * A root comment is a comment that is a direct child of this video
     * @param int $videoId
     * @param Comment $rootComment
     */
    public function addRootComment($videoId, Comment $rootComment);

    /**
     * getRootComments
     * Returns all root comments for the video with this id   
     * @param int $videoId
     * @param int $limit
     * @return Comment[]
     * @throws DBException
     */
    public function getRootComments($videoId, $limit = 100);

    /**
     * removeRootComment
     * Removew a root comment from this video.
     * A root comment is a comment that is a direct child of this video
     * @param int $vidoeId
     * @param int $commentId
     */
    public function removeRootComment($vidoeId, $commentId);
    
    /**
     * updateLikes
     * Updates the likes for a video
     * @param int $videoId
     * @param int $newLikes
     */
    public function updateLikes($videoId, $newLikes);
    
    /**
     * updateViews
     * Updates the views for a video
     * @param int $videoId
     * @param int $newViews
     */
    public function updateViews($videoId, $newViews);
}
