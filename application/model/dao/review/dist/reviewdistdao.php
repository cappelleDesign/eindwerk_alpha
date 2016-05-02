<?php

interface ReviewDistDao {

    public function addUserScore($reviewId, $userId, $userScore);

    public function removeUserScore($reviewId, $userId);

    public function udpateUserScore($reviewId, $userId, $newScore);

    public function addVoter($reviewId, $voterId, $voterFlag);

    public function removeVoter($reviewId, $voterId);

    public function updateVoter($reviewId, $voterId, $voterFlag);

    public function addRootComment($reviewId, Comment $rootComment);

    public function removeRootComment($reviewId, $commentId);

    public function updateRootcomment($reviewId, $commentId, Comment $rootComment);

    public function addGoodBadTag($reviewId, $goodBadTag);

    public function removeGoodBadTag($reviewId, $goodBadTagId);

    //FIXME should there be an update goodBadTag ?

    public function addGalleryImage($reviewId, Image $image);

    public function removeGalleryImage($reviewId, $imageId);

//    GAME RELATED
    public function updateGame($reviewId, Game $game);
}
