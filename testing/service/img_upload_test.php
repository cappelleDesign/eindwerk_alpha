<h1>IMAGE UPLOADING TESTS</h1>
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
    $nowWithTime = DateFormatter::getNow()->format($format);
    $obj = '';
    $configs = getConfigs();
    $service = new MasterService($configs);
    $files = $service->getCleanFilesArray($_FILES['uploadImg']);    
    $admin = $service->get(7, 'user');    
    $extra = array(
        0 => $files[0],
        1=>'3'
    );
    
    $review = $service->get(1, 'review');    
//    $service->removeFromReview($review, 'gallery', 6);
    
//    $obj = $service->get(1,'newsfeed');
//    $newsfeed = new NewsfeedItem($admin->getId(), $admin->getUsername(), NULL, 'test to remove', 'this should be removed', $nowWithTime, $format);
//    $service->add($newsfeed, 'newsfeed', $extra[0]);
//      $newsfeed = $service->get(3, 'newsfeed');
//    $service->updateNewsfeed($newsfeed, 'image', $extra[0]);
//    $service->remove($newsfeed, 'newsfeed');
    
    if (!empty($_FILES['uploadImg']['size'])) {
        
    } else {
        echo 'not fully filled in';
    }
    Globals::cleanDump($obj);
    echo '<h1 style="color:green">SUCCESS</h1>';
} catch (Exception $ex) {
    echo '<h1 style="color:red">ERROR</h1>';
    Globals::cleanDump($ex);
}
?>


