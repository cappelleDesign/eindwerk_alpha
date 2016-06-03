<?php

interface ReviewsDao extends VoteFunctionalityDao {
    
    public function getReviews($limit = -1, $orderType = 'date', $order = 'DESC');    
    
    public function getUserReviews($gameId);

    public function updateReviewCore($reviewId, $reviewedOn, $title, $score, $text, $videoUrl, Image $headerImg, $goods, $bads, $tags, $gallery, $format);

    public function addUserScore($reviewId, $userId, $userScore);

    public function removeUserScore($reviewId, $userId);

    public function udpateUserScore($reviewId, $userId, $newScore);

    public function addRootComment($reviewId, Comment $rootComment);
    
    public function removeRootComment($reviewId, $commentId);
    
    public function updateRootcomment($reviewId, $commentId, Comment $rootComment);
    
    public function addGoodBadTag($reviewId,$goodBadTag);
    
    public function removeGoodBadTag($reviewId, $goodBadTagId);
    
    public function addGalleryImage($reviewId, Image $image);
    
    public function removeGalleryImage($reviewId, $imageId);   
    
//    GAME RELATED
    public function updateGame($reviewId, Game $game);
}
