<?php

class NewsfeedsController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('newsfeed');
    }

    public function get($id, $limit = NULL, $txtMatch = NULL) {
        $newsfeeds = -1;
        if($id == 'all') {
            $options = $this->buildOptionsArr($limit, $txtMatch);
            $newsfeeds = $this->getService()->getAll('newsfeed', $options);
        } else if(is_numeric($id)){
            $newsfeeds = array($this->getService()->get($id, 'newsfeed'));
        }
        if($newsfeeds !== -1) {
            echo $this->getJson($newsfeeds);
        } else {
            echo 'No newsfeeds found!';
        }
    }

    private function buildOptionsArr($limit = NULL, $txtMatch = NULL) {
        $options = array();
        if($limit && is_numeric($limit)) {
            $options['limit'] = $limit;
        }
        if($txtMatch) {
            $options['subject'] = $txtMatch;
            $options['body'] = $txtMatch;
        }
        return $options;
    }

}
