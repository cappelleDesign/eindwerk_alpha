<?php

/**
 * DateFormatter
 * This class formats dates to meet user timezone and date display conventions.
 * @package model
 * @subpackage domain.general
 * @author Jens Cappelle <cappelle.design@gmail.com>
 */
//FIXME use this plugin? http://www.jqueryscript.net/time-clock/jQuery-Plugin-To-Render-Time-In-Users-Timezone-usertime-js.html
//https://bitbucket.org/pellepim/jstimezonedetect

class DateFormatter {
    
    public static function getDateTimeInZone($format, $originalDate,$zone) {
        $date = DateTime::createFromFormat($format, $originalDate, new DateTimeZone('utc'));
        $date->setTimeZone(new DateTimeZone($zone));
        return $date;
   }
    
   public static function convertToServerTimeZone($format, $originalDate) {
       $timezone = date_default_timezone_get();
       $date = DateTime::createFromFormat($format, $originalDate, $originalDate->get);
   }
}
