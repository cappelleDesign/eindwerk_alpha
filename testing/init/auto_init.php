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
//    newsfeeds
    if (isset($_POST['newsfeedField'])) {
        echo 'newsfeed';
        $writer = $service->getByIdentifier('jens_admin', 'user');
        $writerId = $writer->getId();
        $writerName = $writer->getUsername();
        $image = NULL;
        $subject = 'Launch';
        $body = '&lt;li&gt;&lt;p&gt;The Neoludus website will be launching soon!&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;The first reviews are being made&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;Podcasts will follow soon&lt;/p&gt;&lt;/li&gt;';
        $created = $nowWithTime;
        $dateFormat = $format;
        $newsfeed = new NewsfeedItem($writerId, $writerName, $image, $subject, $body, $created, $dateFormat);
        $service->add($newsfeed, 'newsfeed', $files[0]);

        $subject = 'First review';
        $body = '&lt;li&gt;&lt;p&gt;The first review will be about Darksouls&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;The Darksouls 3 review is almost ready&lt;/p&gt;&lt;/li&gt;';
        $created = $nowWithTime;
        $newsfeed = new NewsfeedItem($writerId, $writerName, $image, $subject, $body, $created, $dateFormat);
        $service->add($newsfeed, 'newsfeed', $files[1]);
//        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, eos, fugit enim rerum ipsa quae ut a odit unde error corrupti dolorem eius ipsum amet aut saepe perferendis necessitatibus provident .
        $subject = 'Newsfeed long';
        $body = '&lt;li&gt;&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit.&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;Est, eos, fugit enim rerum ipsa quae ut a odit unde error corrupti dolorem eius ipsum amet aut saepe perferendis necessitatibus provident .&lt;/p&gt;&lt;/li&gt;';
        $created = $nowWithTime;
        $dateFormat = $format;
        $newsfeed = new NewsfeedItem($writerId, $writerName, $image, $subject, $body, $created, $dateFormat);
        $service->add($newsfeed, 'newsfeed', $files[2]);

        $subject = 'Newsfeed short';
        $body = '&lt;li&gt;&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;&lt;/li&gt;';
        $created = $nowWithTime;
        $dateFormat = $format;
        $newsfeed = new NewsfeedItem($writerId, $writerName, $image, $subject, $body, $created, $dateFormat);
        $service->add($newsfeed, 'newsfeed', $files[3]);

        $subject = 'Newsfeed Medium';
        $body = '&lt;li&gt;&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;Lorem ipsum dolor sit amet&lt;/p&gt;&lt;/li&gt;';
        $created = $nowWithTime;
        $dateFormat = $format;
        $newsfeed = new NewsfeedItem($writerId, $writerName, $image, $subject, $body, $created, $dateFormat);
        $service->add($newsfeed, 'newsfeed', $files[4]);

        $subject = 'Lorem Ipsum';
        $created = $nowWithTime;
        $dateFormat = $format;
        $newsfeed = new NewsfeedItem($writerId, $writerName, $image, $subject, $body, $created, $dateFormat);
        $service->add($newsfeed, 'newsfeed', $files[5]);
        die();
    }
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

    $name = 'Lorem 1';
    $release = '01/01/2016';
    $officialWebsite = 'https://lorem.com/';
    $publisher = 'Lorem ipsum';
    $developer = 'Ipsum';
    $minPlayersOnline = '2';
    $maxPlayersOnline = '8';
    $maxPlayersOffline = '1';
    $maxPlayersStory = '1';
    $hasStoryMode = $maxPlayersStory ? '1' : '0';
    $genres = array('Action-adventure', 'platform');
    $reviewedOn = 'Playstation 4';
    $title = 'Lorem ipsum 1';
    $score = '4';
    $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lacinia dui ac nulla rutrum, vel vestibulum ligula tempor. Nulla tempus pretium feugiat. Morbi finibus auctor libero, eget lobortis risus maximus maximus. Duis libero risus, imperdiet at nibh eu, facilisis condimentum tellus. Fusce rutrum sem neque, a tempus enim dictum eget. Proin eget magna vel velit bibendum commodo non nec nisl. Mauris sodales ipsum ut tincidunt elementum. Aliquam fringilla dictum est, non sodales tortor posuere in. Cras finibus tincidunt lobortis. Cras posuere eros at neque dignissim lacinia.';
    $videoUrl = 'https://www.youtube.com/watch?v=U9bOQNSpjSY';
    $goods = array('good 1', 'good 2', 'good 3');
    $bads = array('bad 1', 'bad 2');
    $tags = array('lorem', 'ipsum', 'dolor', 'sit', 'amet');
    if (isset($_POST['lorem']) && $_POST['lorem'] == 1) {
        echo 'lorem 1';
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
    $name = 'Lorem 2';
    $release = '01/02/2016';
    $title = 'Lorem ipsum 2';
    $score = '5';
    if (isset($_POST['lorem']) && $_POST['lorem'] == 2) {
        echo 'lorem 2';
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
    $name = 'Lorem 3';
    $release = '03/01/2016';
    $title = 'Lorem ipsum 3';
    $score = '6';
    if (isset($_POST['lorem']) && $_POST['lorem'] == 3) {
        echo 'lorem 3';
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
    $name = 'Lorem 4';
    $release = '01/04/2016';
    $title = 'Lorem ipsum 4';
    $score = '7';
    if (isset($_POST['lorem']) && $_POST['lorem'] == 4) {
        echo 'lorem 4';
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
    $name = 'Lorem 5';
    $release = '05/01/2016';
    $title = 'Lorem ipsum 5';
    $score = '8';
    if (isset($_POST['lorem']) && $_POST['lorem'] == 5) {
        echo 'lorem 5';
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
    $name = 'Lorem 6';
    $release = '01/06/2016';
    $title = 'Lorem ipsum 6';
    $score = '9';
    if (isset($_POST['lorem']) && $_POST['lorem'] == 6) {
        echo 'lorem 6';
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
    if (isset($_POST['lorem']) && $_POST['lorem'] > 6) {
        $num = $_POST['lorem'];
        echo 'lorem ' . $num;
        $name = 'Lorem ' . $num;
        $release = '21/10/2015';
        $title = 'Rev Lorem ' . $num;
        $score = rand(0, 10);
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