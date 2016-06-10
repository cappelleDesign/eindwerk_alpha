<?php

class VideosController extends SuperController {

    private $_subFolder;

    public function __construct() {
        parent::__construct('video/');        
    }

    public function index() {
        $this->internalDirect('video.php');
    }

    public function liveStreams() {
        $this->internalDirect('live.php');
    }

    public function letsPlays() {
        $this->internalDirect('lets_play.php');
    }

    public function podcasts() {
        $this->internalDirect('podcast.php');
    }

}
