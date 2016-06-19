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
    $formatNoTime = Globals::getDateTimeFormat('be', FALSE);
    $nowWithTime = DateFormatter::getNow()->format($format);
    $obj = '';
    $configs = getConfigs();
    $service = new MasterService($configs);
    $files = $service->getCleanFilesArray($_FILES['uploadImg']);
//    Globals::cleanDump(array_slice($files, 5));
//    FOR USER    
    $username = 'jens_admin';
    $pwEncrypted = password_hash('Admin001', PASSWORD_BCRYPT);
    $donated = 0;
    $email = 'dev@neoludus.com';
    $karma = 0;
    $regKey = Globals::randomString(64);
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
    if (isset($_POST['avatarField'])) {
        echo 'avatar ';
    $userRole = $service->getByIdentifier(101, 'userRole');
        $img = new Image('dummy', 'Avatar pic for jens admin');
        $av = new Avatar($img, 4);
        $avatar = $service->add($av, 'avatar', $extra);
        $user = new UserDetailed($userRole, $avatar, $username, $donated, $pwEncrypted, $email, $karma, $regKey, $warnings, $diamonds, $dateTimePref, $created, $lastLogin, $activeTime);
        $service->add($user, 'user');
    }

    //HITMAN REVIEW


    $writer = $service->getByIdentifier('jens_admin', 'user');
    $name = 'Hitman';
    $release = '11/03/2016';
    $officialWebsite = 'https://hitman.com/en-us';
    $publisher = 'Square Enix';
    $developer = 'IO INTERACTIVE';
    $minPlayersOnline = '0';
    $maxPlayersOnline = '0';
    $maxPlayersOffline = '1';
    $maxPlayersStory = '1';
    $hasStoryMode = $maxPlayersStory ? '1' : '0';
    $genres = array('Action-adventure', 'stealth');
    $platforms = array('Windows 10', 'Xbox One', 'Playstation 4');
    $reviewedOn = 'Playstation 4';
    $title = 'Hitman does not let down';
    $score = '8';
    $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lacinia dui ac nulla rutrum, vel vestibulum ligula tempor. Nulla tempus pretium feugiat. Morbi finibus auctor libero, eget lobortis risus maximus maximus. Duis libero risus, imperdiet at nibh eu, facilisis condimentum tellus. Fusce rutrum sem neque, a tempus enim dictum eget. Proin eget magna vel velit bibendum commodo non nec nisl. Mauris sodales ipsum ut tincidunt elementum. Aliquam fringilla dictum est, non sodales tortor posuere in. Cras finibus tincidunt lobortis. Cras posuere eros at neque dignissim lacinia.';
    $videoUrl = 'https://www.youtube.com/watch?v=U9bOQNSpjSY';
    $headerImg = NULL;
    $userScores = array();
    $rootComments = array();
    $voters = array();
    $goods = array('Kill people', 'Nice graphics', 'immersive');
    $bads = array('Too much stealth', 'No big guns', 'Not enough freedom');
    $tags = array('Bald', 'Agent 47', 'hitman', 'action', 'stealth');
    $gallery = array();
    if (isset($_POST['hitmanField'])) {
        echo 'hitman';
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

//    FALLOUT REVIEW
    $name = 'Fallout 4';
    $release = '10/11/2015';
    $officialWebsite = 'https://fallout4.com/';
    $publisher = 'Bethesda Softworks';
    $developer = 'Bethesda Game Studios';
    $genres = array('Action-rpg');
    $title = 'Fallout 4 is on the move';
    $score = '9';
    $goods = array('Awesome story', 'A lot of freedom', 'Hours of fun');
    $bads = array('Graphics are not good enough', 'Loading screens', 'Bugs');
    $tags = array('FO4', 'survive', 'commonwealth', 'build', 'action');
    if (isset($_POST['foField'])) {
        echo 'fallout';
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


    //   SKYRIM REVIEW
    $name = 'Skyrim';
    $release = '11/11/2011';
    $officialWebsite = 'http://www.elderscrolls.com/skyrim';
    $title = 'Skyrim is epic AF';
    $score = '10';
    $tags = array('TES', 'The elder scrolls', 'dragons', 'fantasy', 'action');
    if (isset($_POST['skyField'])) {
        echo 'skyrim';
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
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}