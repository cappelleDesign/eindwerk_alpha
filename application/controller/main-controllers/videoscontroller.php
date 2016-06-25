<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '/system/api/google-api-php-client-2.0.0/src');
require_once 'system/api/google-api-php-client-2.0.0/vendor/autoload.php';

class VideosController extends SuperController {

    private $_subFolder;
    private $_yt_api_key;
    private $_neo_channel_id;
    private $_playlist_id;

//    AIzaSyDXHwnh8F_0iE0bAys6OipeG16DYiTxZfE

    public function __construct() {
        parent::__construct('video/');
        $this->init();
    }

    private function init() {
        $this->_yt_api_key = 'AIzaSyB1tatYXXg11UgkboD3O0seY51b5a6bFCY';
//        $this->_neo_channel_id = 'UCmt2BsAl7VdWx8rsLwBpHNA';
        $this->_neo_channel_id = 'UCT6QFE3peNry9PdO5uGj96g';
        $this->_playlist_id = 'PLy3mMHt2i7RKpHRvK8bKuKWHh2kn33brm';
    }

    public function index() {
        $this->internalDirect('video.php');
    }

    public function liveStreams() {
        $this->internalDirect('live.php');
    }

    public function letsPlays() {
        $videos = $this->getChannel();
        $_POST['videos'] = $videos;
        $this->internalDirect('lets_play.php');
    }

    public function podcasts() {
        $videos = $this->getChannel();
        $_POST['videos'] = $videos;
        $this->internalDirect('podcast.php');
    }

    private function getChannel() {
        $client = new Google_Client();
        $client->setApplicationName('neoludusVideo');
        $client->setDeveloperKey($this->_yt_api_key);

        $youtube = new Google_Service_YouTube($client);
        $videos = $youtube->playlistItems->listPlaylistItems('snippet', array(
            'playlistId' => $this->_playlist_id,
            'maxResults' => 10
        ));
        return $videos;
    }

}
