<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 02.07.12
 * Time: 19:39
 *
 */
class Module implements ModuleManagerInterface
{
    protected $view;
    protected $name;
    protected $app;

    public function _construct(){
        $this->name = get_class($this);
        $this->view = "index";
        $this->app = new Application();
    }

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

    protected function loadFile($name, $type, $path = null){
         switch($type){
             case "css":
                 if($path == null)
                     echo "<link rel='stylesheet' type='text/css' href='".$this->app->getHomeUrl()."modules/".strtolower($this->name)."/views/css/".$name."' />";
                 else
                     echo "<link rel='stylesheet' type='text/css' href='".$path.$name."' />";
                 break;
             case "javascript":
                 if($path == null)
                     echo "<script src='".$this->app->getHomeUrl()."modules/".strtolower($this->name)."/views/js/".$name."' type='text/javascript' charset='utf-8'></script>";
                 else
                     echo "<script src='".$path.$name."' type='text/javascript' charset='utf-8'></script>";
                 break;
         }
    }
}
