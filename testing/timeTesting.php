<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">        
        <title></title>
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
//        echo $timeZone;
        $date2 = DateFormatter::getDateTimeInZone('d/m/Y H:i:s', $date->format('d/m/Y H:i:s'), $timeZone);
        echo $date2->format('d/m/Y H:i:s') . ' --- ' . $date2->getTimeZone()->getName();
        echo '<br>';
        echo date_default_timezone_get();
        ?>
        <script src="view/js/jquery-2.2.0.min.js"></script>
        <script src="view/js/plugins/cookies/js.cookie.js"></script>
        <script src="view/js/plugins/datetime/jstz.min.js"></script>
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
