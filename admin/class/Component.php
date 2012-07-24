<?php

/**
 * Class for components Controllers.
 */

/**
 * Class for components Controllers, manage all the application.
 * @package core
 * @subpackage controller
 */
class Component extends Controller
{

    /**
     * Path to component.
     * @var
     */
    private $path;

    /**
     *Constructor check url and active controller and actions from them.
     *@throws Exception
     */
    public function __construct(){
      Application::sessionStart();
      parent::getName();
      parent::dependencies();
      $this->generateModels();
      parent::generateControllers();
      $this->app = new Application();
      $this->path = $this->app->getHomeUrl()."components/".$this->component."/";

        if( (count($this->controllers) == 0) || ($this->controllers[0] == strtolower(preg_replace("/Controller/","",get_class($this)))) ){
            $this->rendered = true;
            $this->renderIndex();
        }
        elseif( count($this->controllers) < 2 || ($this->getName() != $this->controllers[1]) ){
           $this->redirect();
        }

        /*If don't find any controller or action*/
        if(!$this->rendered){
            throw new Exception("Site don't found.");
        }
    }

    /**
     *Clear dependecies and stop session.
     */
    public function __destruct(){
        parent::__destruct();
    }


    /**
     *Method generate model if model exist.
     */
    protected function generateModels(){
        $className = get_class($this);
        $modelName = preg_replace("/Controller/","",$className)."Model";
        if(file_exists(Application::getBaseDir()."components/".$this->component."/model/".$modelName.".php"))
            $this->model = new $modelName();
    }

    /**
     *Render index file
     */
    protected function renderIndex(){
        $this->render("index");
    }

    /**
     * Render view. $name must have that same value like file name in view folder.
     * @param string $name
     */
    public function render($name){

        $this->beforeRender();
        /*Get view*/
        $this->file =  $this->app->getBaseDir()."components/".$this->component."/views/".$this->name."/".$name.".php";
        /*Get template*/
        include_once($this->app->getBaseDir()."templates/".$this->app->getTemplate()."/index.php");
        $this->afterRender();
    }

    /**
     * Generate view
     */
    private function view(){
        if(file_exists($this->file)){
            ob_start();
            require_once($this->file);
            $contents = ob_get_contents();
            ob_end_clean();
            echo $contents;
        }
        else
            include_once(Application::getBaseDir()."error/errorfile.php");
    }


    /**
     * Load css and js files
     * @param $name
     * @param $type
     * @param null $path
     */
    protected function loadFile($name = null, $type = null, $path = null){
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
                    $file_info = new finfo(FILEINFO_MIME);
                    $mime_type = $file_info->buffer(file_get_contents($path));
                    switch($mime_type){
                        case"text/css";
                            echo "<link rel='stylesheet' type='text/css' href='".$path.$name."' />";
                            break;
                        case"text/javascript";
                            echo "<script src='".$path.$name."' type='text/javascript' charset='utf-8'></script>";
                            break;
                    }
                }
                elseif($path != null && $name == null){
                    $file_info = new finfo(FILEINFO_MIME);
                    $mime_type = $file_info->buffer(file_get_contents($path));
                    switch($mime_type){
                        case"text/css";
                            echo "<link rel='stylesheet' type='text/css' href='".$path."' />";
                            break;
                        case"text/javascript";
                            echo "<script src='".$path."' type='text/javascript' charset='utf-8'></script>";
                            break;
                    }
                }
                break;
        }
    }

    /**
     * Returning a name of controller.
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Load module in view.
     * @param $name
     * @return mixed
     */
    public function module($name){
        Loader::import("modules.".strtolower($name).".*","modules.".strtolower($name).".views.*" );
        return new $name;
    }

    /**
     * Check if controller file exists.
     * @param string $name
     * @return bool
     */
    protected  function checkController($name){
        return file_exists(Application::getBaseDir()."components/".strtolower($this->getName())."/controller/".$name.".php");
    }

    /**
     * Returning a Controller model.
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *Method after render a view.
     */
    protected function afterRender(){

    }

    /**
     *Method before render a view.
     */
    protected function beforeRender(){

    }

    /**
     * Path to component.
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
