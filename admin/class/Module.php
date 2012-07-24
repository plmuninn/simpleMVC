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
     * Path to module.
     * @var
     */
    private $path;

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
        $this->path = $this->app->getHomeUrl()."modules/".strtolower($this->name)."/";
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
     * @param null $path
     * @param null $name
     * @param null $type
     */
    protected function loadFile($path = null , $name = null, $type = null){
        switch($type){
            case "css":
                if($path == null)
                    echo "<link rel='stylesheet' type='text/css' href='".$this->path."css/".$name."' />";
                else
                    echo "<link rel='stylesheet' type='text/css' href='".$path.$name."' />";
                break;
            case "javascript":
                if($path == null)
                    echo "<script src='".$this->path."js/".$name."' type='text/javascript' charset='utf-8'></script>";
                else
                    echo "<script src='".$path.$name."' type='text/javascript' charset='utf-8'></script>";
                break;
            case "js":
                if($path == null)
                    echo "<script src='".$this->path."js/".$name."' type='text/javascript' charset='utf-8'></script>";
                else
                    echo "<script src='".$path.$name."' type='text/javascript' charset='utf-8'></script>";
                break;
            case null:
                if($path != null && $name != null){
                    $file_info = $name;
                    $mime_type = explode(".",$name);
                    switch($mime_type[count($mime_type) -1]){
                        case"css";
                            echo "<link rel='stylesheet' type='text/css' href='".$path.$name."' />";
                            break;
                        case"js";
                            echo "<script src='".$path.$name."' type='text/javascript' charset='utf-8'></script>";
                            break;
                    }
                }
                elseif($path != null && $name == null){
                    $file_info = $name;
                    $mime_type = explode(".",$path);
                    switch($mime_type[count($mime_type) -1]){
                        case"css";
                            echo "<link rel='stylesheet' type='text/css' href='".$path."' />";
                            break;
                        case"js";
                            echo "<script src='".$path."' type='text/javascript' charset='utf-8'></script>";
                            break;
                    }
                }
                break;
        }
    }

    /**
     * Path to module.
     * @return
     */
    public function getPath()
    {
        return $this->path;
    }
}
