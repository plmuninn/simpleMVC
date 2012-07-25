<?php
require_once("interfaces/LoaderInterface.php");
/**
 * Loader class
 */
/**
 * Loader class, can manage a importing files
 * @package core
 * @subpackage helper
 */
class Loader implements LoaderInterface
{
    /**
     *Nothing
     */
    public function  __construct(){}

    /**
     *Nothing
     */
    public function  __destruct(){}

    /**
     * Function auto-loading class files.
     * @static
     * @param $class_name
     * @return mixed|void
     */
    public static function  autoload($class_name){
        if(!preg_match("[^Controller$]", $class_name) && preg_match("[Controller$]", $class_name)){

            if(file_exists(BASE_DIR."controller/".$class_name.".php"))
                    require_once  BASE_DIR."controller/".$class_name.".php";
        }
        else if(!preg_match("[^Model$]", $class_name) && preg_match("[Model$]", $class_name)){

            if(file_exists(BASE_DIR."model/".$class_name.".php"))
                    require_once  BASE_DIR."model/".$class_name.".php";
        }
        else if(!preg_match("[^Interface$]", $class_name) && preg_match("[Interface$]", $class_name)){

            if(file_exists(BASE_DIR."admin/class/interfaces/".$class_name.".php"))
                    require_once  BASE_DIR."admin/class/interfaces/".$class_name.".php";
        }
        else{
            if(file_exists(BASE_DIR."admin/class/".$class_name.".php"))
                require_once  BASE_DIR."admin/class/".$class_name.".php";
        }

    }

    /**
     * Method importing files
     * @static
     * @param $package
     * @param null $exceptions
     * @return mixed|void
     */
    public static function import($package, $exceptions = null)
    {
        $app = new Application();
        $package = explode(".",$package);
        $path = "";
        $all = false;
        for($i = 0 ; $i < count($package); $i++){
                  if($package[$i] == "*")
                      $all = true;
                  else
                      $path .=($i == 0 ? "" : "/").$package[$i];
        }
        if($all){
           $files = FileManager::getAll($app->getBaseDir().$path);
                if(is_array($files))
                    Loader::loadFolder($files,$app->getBaseDir().$path, $exceptions);
        }
        else{
          if($exceptions == null){
              if(Loader::checkClass($app->getBaseDir().$path.".php"))
              require_once($app->getBaseDir().$path.".php");
          }
            else{
                $exception_path = "";
                $exceptions = explode(".",$exceptions);
                for($i = 0 ; $i < count($exceptions); $i++){
                    if($exceptions[$i] == "*")
                        $all = true;
                    else
                    $exception_path .=($i == 0 ? "" : "/").$exceptions[$i];
                }
                if($all == true){
                    $files = FileManager::getAll($app->getBaseDir()."/".$exception_path);
                            if(is_array($files))
                                Loader::loadFile($files,$app->getBaseDir()."/".$path);
                }
                else
                    if($path != $exception_path) {
                        if(Loader::checkClass($app->getBaseDir().$path.".php"))
                        require_once($app->getBaseDir().$path.".php");
                    }
            }
        }
    }

    /**
     * Recursive loading from folder files method
     * @static
     * @param $files
     * @param $path
     * @param $exceptions
     */
    private static function loadFolder($files, $path, $exceptions){
        $app = new Application();
        if($exceptions == null){
            foreach($files as $value){
                if(is_file($path."/".$value)){
                    if(Loader::checkClass($path."/".$value))
                    require_once($path."/".$value);
                }
                elseif (is_dir($path."/".$value)){
                  $newFiles = FileManager::getAll($path."/".$value);
                    Loader::loadFolder($newFiles,$path."/".$value, $exceptions);
                }
            }
        }
        else{
            $all = false;
            $exception_path = "";

            if(!is_array($exceptions))
            $exceptions = explode(".",$exceptions);

            for($i = 0 ; $i < count($exceptions); $i++){
                if($exceptions[$i] == "*")
                    $all = true;
                else
                    $exception_path .=($i == 0 ? "" : "/").$exceptions[$i];
            }

            if($all == true){
                $exception_path = explode("/",$exception_path);
                foreach($files as $value){
                    if(is_file($path."/".$value)){
                        if(Loader::checkClass($path."/".$value))
                            require_once($path."/".$value);
                    }
                    elseif (is_dir($path."/".$value)){
                        if(!in_array($value,$exception_path)){
                        $newFiles = FileManager::getAll($path."/".$value);
                            Loader::loadFolder($newFiles,$path."/".$value, $exceptions);
                        }
                    }
                }
            }
            else{
                foreach($files as $value){
                    if(is_file($path."/".$value)){
                        if($path."/".$value != $app->getBaseDir().$exception_path.".php"){
                            if(Loader::checkClass($path."/".$value))
                            require_once($path."/".$value);
                        }
                    }
                    elseif (is_dir($path."/".$value)){
                        $newFiles = FileManager::getAll($path."/".$value);
                        Loader::loadFolder($newFiles,$path."/".$value, $exceptions);
                    }
                }
            }
        }
    }

    /**
     * Function is loading file if is not like exception
     * @static
     * @param $files
     * @param $path
     */
    private static function loadFile($files,$path){
        $app = new Application();
        $path = explode("/",$path);
        $path = array_reverse($path);
         if(!in_array($files,$path[0])){
             $path = array_reverse($path);
             $path = implode("/",$path);
             if(Loader::checkClass($app->getBaseDir().$path.".php"))
             require_once($app->getBaseDir().$path.".php");
        }
    }

    /**
     * Downloaded from http://stackoverflow.com/questions/928928/determining-what-classes-are-defined-in-a-php-class-file
     * @static
     * @param $path
     * @return bool
     */
    public static function checkClass($path){
            $php_code = file_get_contents($path);
            $classes = Loader::get_php_classes($php_code);
            if(count($classes) >0){
                return true;
            }
                else
            return false;
    }

    /**
     * Downloaded from http://stackoverflow.com/questions/928928/determining-what-classes-are-defined-in-a-php-class-file
     * @static
     * @param $path
     * @param $name
     * @return bool
     */
    public static function checkClassName($path, $name){
        $php_code = file_get_contents($path);
        $classes = Loader::get_php_classes($php_code);
        if(count($classes) == 1){
            if(strtolower($classes[0]) == strtolower($name))
                return true;
                else
                    return false;
        }
        else
            return false;
    }

    /**
     * Downloaded from http://stackoverflow.com/questions/928928/determining-what-classes-are-defined-in-a-php-class-file
     * @static
     * @param $php_code
     * @return array
     */
    private static function get_php_classes($php_code) {
        $classes = array();
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if (   $tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING) {

                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }
        return $classes;
    }

}
