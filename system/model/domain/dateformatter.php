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
    /**
     * getDateTimeZone
     * Creates a DateTime object for this particular time zone
     * @param string $format
     * @param string $originalDate
     * @param string $zone
     * @return DateTime
     */
    public static function getDateTimeInZone($format, $originalDate,$zone) {
        $date = DateTime::createFromFormat($format, $originalDate, new DateTimeZone('utc'));
        $date->setTimeZone(new DateTimeZone($zone));
        return $date;
   }
    
   /**
    * convertToServerTimeZone
    * Converts the given DateTime to a DateTime object with the servers default timezone
    * @param string $format
    * @param string $originalDate
    * @return DateTime
    */
   public static function convertToServerTimeZone($originalDate) {
       $timezone = date_default_timezone_get();
       $date = DateTime::createFromFormat('d/m/Y H:i:s', $originalDate->format('d/m/Y H:i:s'),$originalDate->getTimezone());
       $date->setTimeZone(new DateTimezone($timezone));
       return $date;
   }
  
   /**
    * getNow
    * Returns now as a DateTime object
    * @return DateTime
    */
   public static function getNow() {
       $date = new DateTime('now', new DateTimeZone('utc'));
       return $date;
   }
}
