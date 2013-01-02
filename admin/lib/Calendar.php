<?php
/**
 * Class for  print dates, times, timestamps etc.
 */

/**
 * Calendar Class to print dates, times, timestamps etc.
 * @package core
 * @subpackage helper
 */
class Calendar
{
    /**
     * Configuration class instance.
     * @var Configuration
     */
    private $configuration;

    /**
     *Setting time zone from Configuration class.
     */
    function __construct()
    {
        $this->configuration = new Configuration();
        $zone = $this->configuration->settings('time_zone');
        $array = $this->configuration->getTimeZones();
        $key = array_search($zone, $array);
        date_default_timezone_set($key);
    }

    /**
     * Clearing instance.
     */
    function __destruct()
    {
        $this->configuration = null;
    }

    /**
     * Method return actual date.
     * @return string actual date
     */
    public static function today()
    {
        $cal = new Calendar();
        return date($cal->configuration->settings('date_format'));
    }

    /**
     * Method return actual time.
     * @return string actual time
     */
    public static function now()
    {
        $cal = new Calendar();
        return date($cal->configuration->settings('time_format'));
    }

    /**
     * Return timestamp date.
     * @static
     * @param int $year
     * @param int $month
     * @param int $day
     * @return string timestamp date */
    public static function changedDate($year = 0, $month = 0, $day = 0)
    {
        $cal = new Calendar();
        $nextDate = mktime(0, 0, 0, date("m") + $month, date("d") + $day, date("Y") + $year);
        return date($cal->configuration->settings('time_format'), $nextDate);
    }


    /**
     * Return timestamp time.
     * @static
     * @param int $hour
     * @param int $minutes
     * @param int $seconds
     * @return string
     */
    public static function changedTime($hour = 0, $minutes = 0, $seconds = 0)
    {
        $cal = new Calendar();
        $nextDate = mktime(date("G") + $hour, date("i") + $minutes, date("s") + $seconds, 0, 0, 0);
        return date($cal->configuration->settings('time_format'), $nextDate);
    }

}

