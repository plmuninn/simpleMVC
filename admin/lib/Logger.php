<?php
/**
 * Class log errors to file.
 */
/**
 * Class log errors to file.
 * @package core
 * @subpackage error
 */
class Logger
{
    /**
     *Nothing
     */
    public function  __construct()
    {
    }

    /**
     *Nothing
     */
    public function  __destruct()
    {
    }

    /**
     * Method save log in file
     * @static
     * @param $type
     * @param $message
     * @param $file
     * @param $line
     */
    static public function log($type, $message, $file, $line)
    {
        $log = "Created time " . date("[d.m.y]") . " on " . date("[H:i:s]") . " : Type " . $type . " in file: '" . $file . "' on line " . $line . " message '" . $message . "';";
        FileManager::createFolder(Application::getBaseDir() . "logs");
        FileManager::createFile(Application::getBaseDir() . "logs", date("d.m.y") . ".txt");
        FileManager::writeToFile(Application::getBaseDir() . "logs/" . date("d.m.y") . ".txt", $log);
    }
}
