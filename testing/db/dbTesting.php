<?php
spl_autoload_register(function ($class_name) {
    $root = dirname(__FILE__);
    $dirs = array(
        '/../model/',
        '/../model/errorhandling/',
        '/../model/domain/general/',
        '/../model/domain/user/',
        '/../model/domain/review/',
        '/../model/dao/general/',
        '/../model/dao/user/',
        '/../model/dao/user/dist/',
        '/../model/dao/user/notification/'
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
    if (!$fileFound) {
        //handle exception
    }
});

$user_db = new UserSqlDB('127.0.0.1', 'neoludus_admin', 'Admin001', 'neoludus');

//echo 'Is email jens@localhost.be available? ';
//echo $user_db->emailAvailable('jens@localhost.be') ? 'yes' : 'no';
//echo '<br>';
//echo 'Is username jens still available? ';
//echo $user_db->usernameAvailable('jens') ? 'yes' : 'no';
//echo '<br>';
//echo 'Is there a user with id 1? ';
//echo $user_db->containsId(1, 'user') ? 'yes' : 'no';
//echo '<br>';
//echo 'User with id 1 is: ';
//$notification = new Notification(1 , 'testing return id', '21/10/1989 00:00:00', false, Globals::getDateTimeFormat('be', true));
//echo $user_db->addNotification(1, $notification);
try {
    $user = $user_db->get(1);
    $name = $user->getUsername();
} catch (Exception $ex) {
    echo $ex;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">        
        <title></title>
    </head>
    <body>
        <h1>User profile</h1>
        Id: <?php echo $user->getId(); ?>
        <br>
        Username: <?php echo $user->getUsername(); ?>
        <br>        
        Dontated: <?php echo $user->getDonated(); ?>
        <br>                
        PW HASH: <?php echo $user->getPwEncrypted(); ?>
        <br>                
        Email: <?php echo $user->getEmail(); ?>
        <br>
        Karma: <?php echo $user->getKarma(); ?>
        <br>
        RegKey: <?php echo $user->getRegKey(); ?>
        <br>
        Warnings: <?php echo $user->getWarnings(); ?>
        <br>
        Diamonds: <?php echo $user->getDiamonds(); ?>
        <br>
        Date and time setting: <?php echo $user->getDateTimePref(); ?>
        <br>
        Created: <?php echo $user->getCreatedStr($user->getDateTimePref()); ?>
        <br>
        Last login: <?php echo $user->getLastLoginStr($user->getDateTimePref()); ?>
        <br>
        Active time: <?php echo $user->getActiveTime(); ?>
        <br>
        --------------------------------------------------
        <?php $userRole = $user->getUserRole(); ?>
        <h1>User User role</h1>
        Id: <?php echo $userRole->getId(); ?>
        <br>
        Name: <?php echo $userRole->getName(); ?>
        <br>
        AccessFlag: <?php echo $userRole->getAccessFlag(); ?>
        <br>
        Karma minimum: <?php echo $userRole->getKarama_min(); ?>
        <br>
        Diamond minimum: <?php echo $userRole->getDiamond_min(); ?>
        <br>
        --------------------------------------------------
        <?php $avatar = $user->getAvatar(); ?>
        <h1>Avatar</h1>
        <img src="../view/images/avatars/tier<?php echo $avatar->getTier() . '/' . $avatar->getImage()->getUrl() ?>" alt="<?php echo $avatar->getImage()->getAlt() ?>">
        <br>
        --------------------------------------------------
        <?php $comment = $user->getLastComment(); ?>
        <h1>Last Comment</h1>
        Id: <?php echo $comment->getId(); ?>
        <br>
        Parent id: <?php echo $comment->getParentId(); ?>
        <br>
        Poster: <?php echo $comment->getPoster()->getUsername(); ?>
        <br>
        ReviewId: <?php echo $comment->getReviewId(); ?>
        <br>
        Body: <?php echo $comment->getBody(); ?>
        <br>
        Voters: <?php print_r($comment->getVoters()); ?>
        <br>
        Time: <?php echo $comment->getCreatedStr(Globals::getDateTimeFormat('be', true));?>
        <br>
        --------------------------------------------------
        <?php
        $notifications = $user->getRecentNotifications();
        echo '<h1>Notifications</h1>';
        foreach ($notifications as $notification) {
            echo $notification->getText();
            echo '<br>';
            echo $notification->getCreatedStr($user->getDateTimePref());
        }
        ?>
        --------------------------------------------------
        <?php
        $achievements = $user->getAchievements();
        echo '<h1>Achievements</h1>';
        foreach ($achievements as $achievement) {
            echo $achievement->getName();
            echo '<br>';
            $path = '../view/images/achievements/';
            $path .= $achievement->getImage()->getUrl();
            echo '<img src="' . $path . '" alt="' . $achievement->getImage()->getAlt() . '" width="200" heigh="200">';
            echo '<br>';
            echo $achievement->getDesc();
        }
        ?>

        <h1>OPERATIONS</h1>
        <?php
//        date_default_timezone_set('UTC');
//        $userDistDB = new UserDistSqlDB('127.0.0.1', 'neoludus_admin', 'Admin001', 'neoludus');
//        $newUserRole = $userDistDB->getUserRole(1);
//        $newAvatar = $userDistDB->getAvatar(1);
//        $newPw = password_hash('Admin001', PASSWORD_BCRYPT);
//        $newRegKey = Globals::randomString(32);
//        $now = date('d/m/Y H:i:s');
//        $newUser = new UserDetailed($newUserRole, $newAvatar, 'FreshMeat', 0, $newPw, 'newMail@mail.com', 0, $newRegKey, 0, 0, globals::getDateTimeFormat('be', true), $now, $now, 0, NULL, NULL, NULL, Globals::getDateTimeFormat('be', true));
//        $user_db->add($newUser);
//        $user_db->remove(3);
//        $userPw = password_hash('Admin002', PASSWORD_BCRYPT);
//        $user_db->updatePw(1, $userPw);
//        $user_db->updateUserDonated(1, 100);
//        $user_db->updateUserKarma(1, 400);
//        $regKey2 = Globals::randomString(32);
//        $user_db->updateUserRegKey(1, $regKey2);
//        $user_db->updateUserWarnings(1, 1);
//        $user_db->updateUserDiamonds(1, 2);
//        $user_db->updateUserDateTimePref(1, Globals::getDateTimeFormat('us', true));
//        $lastLogin = DateTime::createFromFormat(Globals::getDateTimeFormat('be', true), '21/10/1989 12:00:00', new DateTimeZone('utc'));
//        $user_db->updateUserLastLogin(1, $lastLogin);
//        $user_db->updateUserActiveTime(1, 5000);
//        $notif = new Notification(1, 'full user db testing', '25/03/2016 13:00:00', false , Globals::getDateTimeFormat('be', true));
//        $user_db->addNotification(1, $notif);
//        $user_db->updateNotification(13, true);
//        $user_db->removeNotification(13
//        $user_db->updateUserUserRole(1, 2);
//        $user_db->addAchievement(1, 2);
//        $user_db->updateUserAvatar(1, 2);
        ?>
        USER TESTING WAS SUCCESSFUL!
    </body>
</html>