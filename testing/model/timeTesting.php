<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">        
        <title></title>       
        <?php
        $viewRoot = Globals::getRoot('view','app');
        $base = Globals::getBasePath();
        ?>
        <base href="<?php echo $base?>"/>
    </head>
    <body>      
        <?php
        spl_autoload_register(function ($class_name) {
            $root = dirname(__FILE__);
            $dirs = array(
                '/../model/domain/general/',
                '/../model/domain/user/',
                '/../model/domain/review/',
                '/../model/dao/'
            );
            foreach ($dirs as $dir) {
                if (file_exists($root . $dir . strtolower($class_name) . '.php')) {
                    require_once($root . $dir . strtolower($class_name) . '.php');
                    return;
                } else {
                    echo $root . $dir . strtolower($class_name) . 'php not found <br>';
                }
            }
        });
        date_default_timezone_set('utc');        
        $now = date('Y-m-d H:i:s');
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $now);
        echo $date->format('d/m/Y H:i:s');
        echo '<br>';
        $timeZone = 'utc';
        if (isset($_COOKIE['timezone'])) {
            $timeZone = $_COOKIE['timezone'];
        }
        echo 'current timezone: ' . $timeZone . '<br>';
        $date2 = DateFormatter::getDateTimeInZone('d/m/Y H:i:s', $date->format('d/m/Y H:i:s'), $timeZone);
        echo $date2->format('d/m/Y H:i:s') . ' --- ' . $date2->getTimeZone()->getName();
        echo '<br>';
        echo date_default_timezone_get() . '<br>';
        $ogTimeZone = $date2->getTimezone();
        $date3 = DateFormatter::convertToServerTimeZone($date2);
        echo 'server date: ' . $date3->format('d/m/Y H:i:s');
        echo '<br>';
        echo $date2->format('d/m/Y H:i:s');
        echo '<br> original: ' . $date->format('d/m/Y H:i:s') ;
        ?>
        <script src="<?php echo $viewRoot ?>/js/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="<?php echo $viewRoot?>/js/plugins/cookies/js.cookie.js"></script>
        <script src="<?php echo $viewRoot?>/js/plugins/datetime/jstz.min.js"></script>
        <script>
            function getTimezone() {
                var timezone = jstz.determine();
                return timezone.name();
            }
            $(document).ready(function () {
                Cookies.set('timezone', getTimezone());
                console.log(getTimezone());
            });
        </script>
    </body>
</html>
