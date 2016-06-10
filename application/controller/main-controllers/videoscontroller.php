<?php

class VideosController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('video/');        
    }

    public function index() {
        $this->internalDirect('video.php');
    }

    public function liveStream() {
        $this->internalDirect('live.php');
    }

    public function streams() {
        $this->internalDirect('lets_play.php');
    }

    public function podcasts() {
        $this->internalDirect('podcast.php');
    }

}
