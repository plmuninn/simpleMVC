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
     *Constructor check url and active controller and actions from them.
     *@throws Exception
     */
    public function __construct(){
      Application::sessionStart();
      parent::getName();
      parent::getModel();
      parent::dependencies();
      parent::generateControllers();

        if( (count($this->controllers) == 0) || ($this->controllers[0] == strtolower(preg_replace("/Controller/","",get_class($this)))) ){
            $this->rendered = true;
            $this->renderIndex();
        }
        else{
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
        /*Create instance of application configurations and make it global*/
        $this->app = new Application();
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
}
