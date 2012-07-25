<?php
/**
 * Class to manage files.
 */

/**
 * Class is used to manage files.
 * @package core
 * @subpackage helper
 */
class FileManager implements FileInterface
{
    /**
     * Empty
     */
    function __construct()
    {
    }

    /**
     * Empty
     */
    function __destruct()
    {
     }

    /**
     * Create folder if not exits. Name of folder should be at end of $path
     * @static
     * @param string $path
     * @return bool
     */
    public static function  createFolder($path)
    {
        $configuration = new Configuration();
        if(!is_dir($path)){
            mkdir($path,$configuration->getFolderPrev());
            return true;
        }
        return false;
    }

    /**
     * Remove folder if exits. Name of folder should be at end of $path
     * @static
     * @param string $path
     * @return bool
     * @throws Exception
     */
    public static function  removeFolder($path)
    {
          if(is_dir($path)){
              rmdir($path);
              return true;
          }
        else
            new Exception("Path ".$path." not exists.");

        return false;
    }

    /**
     * Create file on $path
     * @static
     * @param string $path
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public static function  createFile($path, $name)
    {
        $configuration = new Configuration();
        $path = $path.(substr($path,-1) != DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : '').$name;
        if(!file_exists($path)){
        $file = fopen($path,"w+");
        fclose($file);
        chmod($path,octdec($configuration->getFilePrev()));
        return true;
        }
        else
            new Exception("File ".$path." exists.");
        return false;
    }

    /**
     * Remove folder on $path
     * @static
     * @param string $path
     * @param string $name
     * @return bool
     */
    public static function  removeFile($path, $name)
    {
        $path = rtrim($path.(substr($path,-1) != DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : '')).$name;
        if(file_exists($path)){
            unlink($path);
            return true;
        }
        return false;
    }

    /**
     * Get all folders ona $path
     * @static
     * @param string $path
     * @return array
     * @throws Exception
     */
    public static function  getFolders($path)
    {
        $path = rtrim($path.(substr($path,-1) != DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : ''));
        $allFiles = self::getAll($path);
        $folders = array();
        foreach($allFiles as $key => $value){
            if(is_dir($path.$value))
                array_push($folders,$value);
        }
        return $folders;
    }

    /**
     * Get all files from $path
     * @static
     * @param string $path
     * @return array
     * @throws Exception
     */
    public static function getFiles($path)
    {
        $path = rtrim($path.(substr($path,-1) != DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : ''));
        $allFiles = self::getAll($path);
        $files = array();
        foreach($allFiles as $key => $value){
            if(is_file($path.$value))
                array_push($files,$value);
        }
        return $files;
    }

    /**
     * Return all files and folders in directory
     * @static
     * @param string $path
     * @return array
     * @throws Exception
     */
    public static function getAll($path)
    {
        rtrim($path = $path.(substr($path,-1) != DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : ''));

       if(is_dir($path)){
          $files = scandir($path);
          unset($files[0]);
          unset($files[1]);
          return $files;
       }
        else
            new Exception($path." is not a directory");
        return null;
    }

    /**
     * Method writing text to file
     * @static
     * @param $path_to_file
     * @param $text
     * @return mixed
     */
    public static function writeToFile($path_to_file, $text)
    {
        if(!is_dir($path_to_file)){
            if(is_file($path_to_file)){
                if(file_exists($path_to_file)){
                $file = fopen($path_to_file,"a");
                fwrite($file,$text."\n");
                    fclose($file);
                }
            }
        }
    }
}
