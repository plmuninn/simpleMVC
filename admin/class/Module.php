<?php
/**
 * A class for modules
 */
/**
 * A class for modules
 * @package core
 * @subpackage controller
 */
class Module
{
    /**
     * Default index view
     * @var
     */
    protected $view;

    /**
     * Module class name
     * @var
     */
    protected $name;

    /**
     * Application instance
     * @var
     */
    protected $app;

    /**
     * Create a instance and set parameters
     */
    public function _construct(){
        $this->name = get_class($this);
        $this->view = "index";
        $this->app = new Application();
    }

    /**
     * Include a view file of module
     */
    protected function render(){
     $file_src = Application::getBaseDir()."modules/".strtolower($this->name)."/views/".$this->view.".php";
        if(file_exists($file_src)){
            ob_start();
            require_once($file_src);
            $contents = ob_get_contents();
            ob_end_clean();
            echo $contents;
        }
        else{
            echo "Brak pliku";
        }
    }

    /**
     * Load css and js files
     * @param $name
     * @param $type
     * @param null $path
     */
    protected function loadFile($name, $type, $path = null){
         switch($type){
             case "css":
                 if($path == null)
                     echo "<link rel='stylesheet' type='text/css' href='".$this->app->getHomeUrl()."modules/".strtolower($this->name)."/css/".$name."' />";
                 else
                     echo "<link rel='stylesheet' type='text/css' href='".$path.$name."' />";
                 break;
             case "javascript":
                 if($path == null)
                     echo "<script src='".$this->app->getHomeUrl()."modules/".strtolower($this->name)."/js/".$name."' type='text/javascript' charset='utf-8'></script>";
                 else
                     echo "<script src='".$path.$name."' type='text/javascript' charset='utf-8'></script>";
                 break;
         }
    }
}
