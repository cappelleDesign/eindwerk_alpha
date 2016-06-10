<?php

class ReviewsController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('review/');
    }

    public function index() {
        $this->internalDirect('reviews.php');
    }

    public function reviewSpecific($reviewId) {
        if (is_numeric($reviewId)) {
            $_POST['rev_id'] = $reviewId;
        } else {
            $_POST['rev_id'] = 'NAN';
        }
        $this->internalDirect('review_specific.php');
    }

}
