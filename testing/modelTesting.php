<?php
spl_autoload_register(function ($class_name) {
    $root = dirname(__FILE__);
    $dirs = array(
        '/../model/domain/general/',
        '/../model/domain/user/',
        '/../model/domain/review/',
        '/../model/dao/'
    );    
    $fileFound = false;
    foreach ($dirs as $dir) {
        if (file_exists($root . $dir . strtolower($class_name) . '.php')) {
            require_once($root . $dir . strtolower($class_name) . '.php');
            $fileFound = true;
            return;
        } else {
            $fileFound = false;
        }
    }
    if(!$fileFound) {
        //handle exception
    }    
});
$pathToImages = '../view/images/';
//USER RELATED
//notifications
$notifications = [];
$notif1 = new Notification(0, 'This is test notification 1', '8/03/2016 01:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif1->setId(0);
$notifications['0'] = $notif1;
$notif2 = new Notification(0, 'This is test notification 2', '8/03/2016 02:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif2->setId(1);
$notifications['1'] = $notif2;
$notif3 = new Notification(0, 'This is test notification 3', '8/03/2016 03:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif3->setId(2);
$notifications['2'] = $notif3;
$notif4 = new Notification(0, 'This is test notification 4', '8/03/2016 04:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif4->setId(3);
$notifications['3'] = $notif4;
$notif5 = new Notification(0, 'This is test notification 5', '8/03/2016 05:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif5->setId(4);
$notifications['4'] = $notif5;
$notif6 = new Notification(0, 'This is test notification 6', '8/03/2016 06:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif6->setId(5);
$notifications['5'] = $notif6;
$notif7 = new Notification(0, 'This is test notification 7', '8/03/2016 07:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif7->setId(6);
$notifications['6'] = $notif7;
$notif8 = new Notification(0, 'This is test notification 8', '8/03/2016 08:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif8->setId(7);
$notifications['7'] = $notif8;
$notif9 = new Notification(0, 'This is test notification 9', '8/03/2016 09:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif9->setId(8);
$notifications['8'] = $notif9;
$notif10 = new Notification(0, 'This is test notification 10', '8/03/2016 10:32:00', false, DomainGlobals::BE_TIME_FORMAT);
$notif10->setId(9);
$notifications['9'] = $notif10;


//achievements
$achievementPic1 = new Image('achievement_dummy1.jpg', 'achievement 1', 'picture for the achievement');
$achievements = [];
$achievement = new Achievement($achievementPic1, 'registered user', 'Register via email', 10, 0);
$achievement->setId(0);
$achievements['0'] = $achievement;

//userRole
$userRole = new UserRole('dummy', 1, 1, 0, 0);

//avatar
$avatar = new Image('tier1/avatar_dummy1.jpg', 'Avatar pic', 'The avater picter of this user');

$userSimple1 = new UserSimple($userRole, $avatar, 'Jens', 10);
$userSimple1-> setId(0);
$userSimple2 = new UserSimple($userRole, $avatar, 'Jens2', 2);
$userSimple2-> setId(1);
//REVIEW RELATED
//game
$platforms = ['0' => 'ps4','1' => 'xbox1','2' => 'ps3'];
$genres = ['0' => 'action' , '1' => 'rpg'];

$game = new Game('game1', '21/10/2014', 'www.game1.com', 'Activision', 'Treyarch', 2, 11, 4, 2, true, $genres, $platforms, DomainGlobals::BE_TIME_FORMAT);

//comment
$voters = ['1' => array('userName' => 'Voter', 'voteFlag' => 2)]; 
$voters2 = ['1' => array('userName' => 'Voter', 'voteFlag' => 2)]; 
$comment1 = new Comment(0, $userSimple1, 0, 'I realy like this game', '25/10/2014', false, $voters, DomainGlobals::BE_TIME_FORMAT);
$comment1->setId(0);
$rootComments = ['0' => $comment1];


//gallery
$gallery = [];
$gallery1 = new Image('gallery_dummy1.jpg', 'gallery pic', 'gallery picture of the review1');
$gallery1->setId(1);
$gallery['1'] = $gallery1;
$gallery2 = new Image('gallery_dummy2.jpg', 'gallery pic', 'gallery picture of the review1');
$gallery2->setId(2);
$gallery['2'] = $gallery2;
$gallery3 = new Image('gallery_dummy3.jpg', 'gallery pic', 'gallery picture of the review1');
$gallery1->setId(3);
$gallery['3'] = $gallery3;
$gallery4 = new Image('gallery_dummy4.jpg', 'gallery pic', 'gallery picture of the review1');
$gallery1->setId(4);
$gallery['4'] = $gallery4;
$gallery5 = new Image('gallery_dummy5.jpg', 'gallery pic', 'gallery picture of the review1');
$gallery1->setId(5);
$gallery['5'] = $gallery5;

$headerImg = new Image('header_dummy.jpg', 'header pic of this review', 'this represents the header pic of this review');

$goods = ['0' => 'Nice graphics', '1' => 'There are boobs'];
$bads = ['2' => 'There are dicks'];
$tags = ['3' => 'action', '4' => 'game1' , '5' => 'boobs'];
$userScores = ['0' => 9, '1'=> 10];

$pw = password_hash('Jens', PASSWORD_BCRYPT);
$regKey =  DomainGlobals::randomString(60);
$detailedUser = new UserDetailed($userSimple1->getUserRole(), $userSimple1->getAvatar(), $userSimple1->getUsername(), $userSimple1->getDonated(), $pw, 'jens@jens.be', 20, $regKey, 0, 0, DomainGlobals::BE_TIME_FORMAT, '01/01/2016 10:00:00', '01/01/2016 10:00:00', 10, '01/01/2016 10:00:00', $notifications, $achievements, 'Europe/Brussels', DomainGlobals::BE_TIME_FORMAT);
$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, aspernatur, nemo, excepturi, impedit incidunt expedita aliquid similique adipisci consequuntur alias eius odio vel voluptas laborum nihil ea aliquam debitis. Vitae.';
$review = new Review($userSimple1, $game, 'Game 1', 8, $text, 'www.youtube.be', '22/10/2014', $headerImg, $userScores, $rootComments, $voters2, $goods, $bads, $tags, $gallery, DomainGlobals::BE_TIME_FORMAT);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>        
    </head>
    <body>
        <h1>Model test cases</h1>
        <h2>User Example</h2>
        <img src="<?php echo $pathToImages . '/avatars/' . $detailedUser->getAvatar()->getUrl()?>" alt="<?php echo $detailedUser->getAvatar()->getAlt()?>" >
        <h3>Username: <?php echo $detailedUser->getUsername()?></h3>
        <h3>UserRole: <?php echo $detailedUser->getUserRole()->getName()?></h3>
        <?php $theImage = $review->getHeaderImg()?>
        <h2> Review exammple</h2>
        <img src="<?php echo $pathToImages . '/games/' . $review->getGame()->getName() . '/' . $theImage->getUrl();?>" alt="">
    </body>
</html>
