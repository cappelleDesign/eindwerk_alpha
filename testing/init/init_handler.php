<?php

function getConfigs() {
    $section = 'database_versio';
    if (strpos(dirname(__FILE__), 'xampp')) {
        $section = 'database_local';
    }
    $configs = parse_ini_file('system//model/config/config.ini', true);
    return $configs[$section];
}

try {
    $format = Globals::getDateTimeFormat('be', TRUE);
    $formatNoTime = Globals::getDateTimeFormat('mysql', FALSE);
    $nowWithTime = DateFormatter::getNow()->format($format);
    $obj = '';
    $configs = getConfigs();
    $service = new MasterService($configs);
    $files = $service->getCleanFilesArray($_FILES['uploadImg']);

//    FOR USER
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = $_POST['username'];
        $pwEncrypted = password_hash($_POST['pw'], PASSWORD_BCRYPT);
        $donated = 0;
        $email = $_POST['email'];
        $karma = 0;
        $regKey = Globals::randomString(60);
        $warnings = 0;
        $diamonds = 0;
        $dateTimePref = 'd/m/Y H:i:s';
        $created = $nowWithTime;
        $lastLogin = $nowWithTime;
        $activeTime = 0;
        $extra = array(
            0 => $files[0],
            1 => $username
        );
        $userRole = $service->getByIdentifier(101, 'userRole');
        $img = new Image('dummy', 'Avatar pic for jens admin');
        $av = new Avatar($img, 4);
        $avatar = $service->add($av, 'avatar', $extra);
        $user = new UserDetailed($userRole, $avatar, $username, $donated, $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime);
        $service->add($user, 'user');
        die();
    }
//    FOR REVIEW
    if (isset($_POST['writerName']) && !empty($_POST['writerName'])) {
        $writer = $service->getByIdentifier($_POST['writerName'], 'user');
        $name = $_POST['gameName'];
        $release = $_POST['release'];
        $officialWebsite = $_POST['website'];
        $publisher = $_POST['publisher'];
        $developer = $_POST['developer'];
        $minPlayersOnline = $_POST['min_online'];
        $maxPlayersOnline = $_POST['max_online'];
        $maxPlayersOffline = $_POST['max_offline'];
        $maxPlayersStory = $_POST['max_story'];
        $hasStoryMode = $maxPlayersStory ? '1' : '0';
        $genres = $_POST['genre'];
        $platforms = $_POST['platform'];

        $reviewedOn = $_POST['rev_plat'];
        $title = $_POST['title'];
        $score = $_POST['score'];
        $text = $_POST['body'];
        $videoUrl = $_POST['vid_url'];
        $headerImg = NULL;
        $userScores = array();
        $rootComments = array();
        $voters = array();
        $goods = $_POST['goods'];
        $bads = $_POST['bads'];
        $tags = $_POST['tags'];
        $gallery = array();

        $extra = $files;
        $service->add($reviewedOn, 'platform');
        foreach ($genres as $genre) {
            $service->add($genre, 'genre', 'descriptions');
        }
        foreach ($platforms as $platform) {
            $service->add($platform, 'platform');
        }

        $game = new Game($name, $release, $officialWebsite, $publisher, $developer, $minPlayersOnline, $maxPlayersOnline, $maxPlayersOffline, $maxPlayersStory, $hasStoryMode, $genres, $platforms, $formatNoTime);
        $review = new Review($writer, $game, $reviewedOn, $title, $score, $text, $videoUrl, $nowWithTime, $headerImg, $userScores, $rootComments, $voters, $goods, $bads, $tags, $gallery, $format);
        $service->add($review, 'review', $extra);
    }
//    $review = $service->get(1, 'review');
//    $service->updateReview($review, 'header', $files[0]);
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}