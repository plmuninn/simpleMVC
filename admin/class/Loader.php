<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 19.07.12
 * Time: 08:26
 *
 */
require_once("interfaces/LoaderInterface.php");
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

    /**Function auto-loading class files;
     * @static
     * @param $class_name
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

    /**Method importing files
     * @static
     * @param $package
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
                    self::loadFolder($files,$app->getBaseDir().$path, $exceptions);
        }
        else{
          if($exceptions == null)
          require_once($app->getBaseDir().$path.".php");
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
                             self::loadFile($files,$app->getBaseDir()."/".$path);
                }
                else
                    if($path != $exception_path)
                        require_once($app->getBaseDir().$path.".php");
            }
        }
    }

    /**Recursive loading from folder files method
     * @param $files
     * @param $path
     */
    private function loadFolder($files, $path, $exceptions){
        $app = new Application();
        if($exceptions == null){
            foreach($files as $value){
                if(is_file($path."/".$value)){
                    require_once($path."/".$value);
                }
                elseif (is_dir($path."/".$value)){
                  $newFiles = FileManager::getAll($path."/".$value);
                    self::loadFolder($newFiles,$path."/".$value, $exceptions);
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
                            require_once($path."/".$value);
                    }
                    elseif (is_dir($path."/".$value)){
                        if(!in_array($value,$exception_path)){
                        $newFiles = FileManager::getAll($path."/".$value);
                        self::loadFolder($newFiles,$path."/".$value, $exceptions);
                        }
                    }
                }
            }
            else{
                foreach($files as $value){
                    if(is_file($path."/".$value)){
                        if($path."/".$value != $app->getBaseDir().$exception_path.".php")
                        require_once($path."/".$value);
                    }
                    elseif (is_dir($path."/".$value)){
                        $newFiles = FileManager::getAll($path."/".$value);
                        self::loadFolder($newFiles,$path."/".$value, $exceptions);
                    }
                }
            }
        }
    }

    /**Function is loading file if is not like exception
     * @param $path
     * @param $exception_path
     */
    private function loadFile($files,$path){
        $app = new Application();
        $path = explode("/",$path);
        $path = array_reverse($path);
         if(!in_array($files,$path[0])){
             $path = array_reverse($path);
             $path = implode("/",$path);
             require_once($app->getBaseDir().$path.".php");
        }
    }
}
