<?php

class ReviewsController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('review/');
    }

    public function index() {
        $this->internalDirect('reviews.php');
    }

    public function detailed($reviewId) {
        if (is_numeric($reviewId)) {
            $_POST['review'] = file_get_contents($this->getBase() . 'reviews/get/' . $reviewId);
        } else {
            $_POST['review'] = 'NAN';
        }
        $this->internalDirect('review_specific.php');
    }

    public function get($id, $limit = NULL, $orderCol = NULL, $order = NULL, $userRev = NULL, $offset = NULL, $platform = NULL, $genre = NULL, $minScore = NULL, $maxScore = NULL, $name = NULL) {
        $message = 'No reviews found!';
        $reviews = -1;
        if ($id == 'all') {
            $options = $this->buildOptionsArr($limit, $orderCol, $order, $userRev, $offset, $platform, $genre, $minScore, $maxScore, $name);
            $reviews = $this->getService()->getAll('review', $options);
        } else if (is_numeric($id)) {
            $reviews = array($this->getService()->get($id, 'review'));
        }
        if ($reviews !== -1) {
            echo $this->getJson($reviews);
        } else {
            echo $message;
        }
    }

    public function handleUserScore() {
        if (isset($_POST['revId']) && isset($_POST['userId']) && isset($_POST['userScore'])) {
            $revId = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'revId'));
            $userId = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'userId'));
            $score = $this->getValidator()->sanitizeInput(filter_input(INPUT_POST, 'userScore'));
            $avg = '';
            try {
                $avg = $this->getService()->addToReview('userScore', $revId, $userId, $score);
            } catch (Exception $ex) {
                $avg = 'internal-error';
                ErrorLogger::logError($ex);
            }
            echo $avg;
        } else {
            echo 'internal-error';
        }
    }

    private function buildOptionsArr($limit = NULL, $orderCol = NULL, $order = NULL, $userRev = NULL, $offset = NULL, $platform = NULL, $genre = NULL, $minScore = NULL, $maxScore = NULL, $name = NULL) {
        $orderCols = array(
            'title',
            'score',
            'created',
            'user_review'
        );
        $options = array(
            'whereOptions' => array(),
            'havingOptions' => array(),
            'orderOptions' => array(),
            'limitOptions' => array()
        );
        if ($platform && $platform !== 'platform_all') {
            $options['whereOptions']['platform'] = $platform;
        }
        if ($genre && $genre !== 'genre_all') {
            $options['whereOptions']['genre'] = $genre;
        }
        if ($name) {
            $options['whereOptions']['gbt'] = $name;
            $options['whereOptions']['gameName'] = $name;
            $options['whereOptions']['title'] = $name;
            $options['whereOptions']['txt'] = $name;
        }
        if ($userRev !== NULL && !empty($userRev) && $userRev !== 'type_all' && is_numeric($userRev)) {
            $options['whereOptions']['userReview'] = $userRev;
        }
        if ($minScore !== NULL && is_numeric($minScore)) {
            $options['havingOptions']['minScore'] = $minScore;
        }
        if ($maxScore !== NULL && is_numeric($maxScore)) {
            $options['havingOptions']['maxScore'] = $maxScore;
        }
        if ($orderCol && $order && in_array($orderCol, $orderCols)) {
            if ($orderCol !== 'user_review') {
                $orderCol = 'review_' . $orderCol;
            }
            $options['orderOptions']['col'] = $orderCol;
            $options['orderOptions']['order'] = $order;
        }
        if ($limit) {
            $options['limitOptions']['limit'] = $limit;
        }
        if ($offset) {
            $options['limitOptions']['offset'] = $offset;
        }
        return $options;
    }

}
