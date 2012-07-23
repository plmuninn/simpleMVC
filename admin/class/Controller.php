<?php
/**
 * A core class for Controllers.
 */
/**
 * Controller class manage all views and actions and render site
 * @package core
 * @subpackage controller
 */
class Controller {


    /**
     * All controllers, actions etc. get from $_GET["url"].
     * @var array
     */
    protected $controllers = array();

    /**
     * All functions.
     * @var array
     */
    protected $functions = array();

    /**
     * Model object if exists a model.
     * @var
     */
    protected $model;

    /**
     * If view was rendered.
     * @var bool
     */
    protected $rendered = false;

    /**
     * Class controller name
     * @var
     */
    protected $name;

    /**
     * Messages callback
     * @var array
     */
    protected $message = array();

    /**
     * Temporary array with controllers, actions etc. get from $_GET["url"].
     * @var
     */
    protected $actions;

    /**
     * Component instance.
     * @var
     */
    protected $component;

    /**
     * Application instance.
     * @var
     */
    protected $app;

    /**
     * File of view path.
     * @var
     */
    protected $file;

    /**
     *Constructor check url and active controller and actions from them.
     *@throws Exception
     */
    function __construct()
    {
           Application::sessionStart();
           $this->generateName();
           $this->generateModels();
           $this->generateControllers();

        /*If index controller*/
        if(!isset($this->component)){
              if($this->controllers[0] == strtolower(preg_replace("/Controller/","",get_class($this)))){
                $this->rendered = true;
                $this->renderIndex();
               }
        }
        else{
            $this->redirectComponent();
        }

        /*If don't find any controller or action*/
        if(!$this->rendered){
          throw new Exception("Site don't found.");
        }

    }

    /**
     * Clean dependencies and close session.
     */
    function __destruct()
    {
        if(isset($_GET["url"]))
        unset($_GET["url"]);

        if(isset($_GET["comp"]))
            unset($_GET["comp"]);

        Application::sessionWrite();
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
        $this->file =  $this->app->getBaseDir()."views/".$this->name."/".$name.".php";
        /*Get template*/
        include_once($this->app->getBaseDir()."templates/".$this->app->getTemplate()."/index.php");
        $this->afterRender();
    }

    /**
     * Render index file.
     */
    protected function renderIndex(){
       $this->render("index");
    }

    /**
     * Check if controller exist.
     * @param string $name
     * @return bool
     */
    protected  function checkController($name){
        return file_exists(Application::getBaseDir()."controller/".$name.".php");
    }


    /**
     * Function redirect to other controller.
     * @return bool
     */
    protected function redirect(){
        foreach($this->controllers as $key =>$value){
            $name = ucfirst($value)."Controller";
            if($this->checkController($name)){
                $site = new $name();
                $this->rendered = true;
                return true;
            }
        }
        return false;
    }

    /**
     * Method check and activate action.
     */
    protected  function functionsCheck(){
        foreach($this->controllers as $key => $value){
            if(in_array($value."Render",$this->functions) && !$this->rendered){
                $name = $value."Render";
                $this->$name();
                $this->rendered = true;
            }
        }
    }

    /**
     * Change location to other view.
     * @param string $view
     * @param bool $admin for admin site true
     */
    protected function redirectToOther($view, $admin){
        $app = new Application();
        header('Location: '.$app->getHomeUrl().($admin == false ? "index.php?url=" : "admin/index.php?url=").$view."");
        exit();
    }

    /**
     * Change location in component.
     * @param $view
     */
    protected function redirectToOtherComponent($view){
        $app = new Application();
        header('Location: '.$app->getHomeUrl()."index.php?url=".$view."&comp=".$this->component);
        exit();
    }

    /**
     * Change component.
     * @param $view
     * @param $component
     */
    protected function changeComponent($view,$component){
        $app = new Application();
        header('Location: '.$app->getHomeUrl()."index.php?url=".$view."&comp=".$component);
        exit();
    }



    /**
     * Generate view.
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
     *Method generate all controllers and add it to class array.
     */
    protected function generateControllers(){
        self::generateName();
        self::dependencies();
        $this->functions = get_class_methods($this);
        $this->controllers = explode("/",$this->actions);
        $this->controllers = array_reverse($this->controllers);
        $this->controllers = array_filter($this->controllers, 'strlen');
        $this->functionsCheck();
    }

    /**
     *Method generate model if model exist.
     */
    protected function generateModels(){
        $className = get_class($this);
        $modelName = preg_replace("/Controller/","",$className)."Model";
        if(file_exists(Application::getBaseDir()."model/".$modelName.".php"))
            $this->model = new $modelName();
    }

    /**
     *Method set name of object from controller.
     */
    protected function generateName(){
        $className = get_class($this);
        $this->name = preg_replace("/Controller/","",$className);
        $this->name  = strtolower($this->name);
    }

    /**
     *Getting site url and component variable.
     */
    protected function dependencies(){
        if(isset($_GET["url"]))
            $this->actions = $actions = $_GET["url"];
        if(isset($_GET["comp"]))
            $this->component =$_GET["comp"];
    }

    /**
     *Method redirect to component class.
     */
    protected function redirectComponent(){
          if(file_exists(Application::getBaseDir()."components/".strtolower($this->component))){
              Loader::import("components.".strtolower($this->component).".*", "components.".strtolower($this->component).".views.*");
                if(file_exists(Application::getBaseDir()."components/".strtolower($this->component)."/controller/".ucfirst($this->component)."Controller.php")){
                   $class  =  Loader::checkClassName(Application::getBaseDir()."components/".strtolower($this->component)."/controller/".ucfirst($this->component)."Controller.php", $this->component."Controller");
                    if($class){
                        $name = ucfirst($this->component)."Controller";
                                 new $name;
                    }
                    else
                        throw new Exception("Component ".$this->component." don't have a controller class or file structure is bad!");
                }
              else
                  throw new Exception("Component ".$this->component." don't have a controller file!");

              $this->rendered = true;
          }
        else
            throw new Exception("Component ".$this->component." not found");
    }

    /**
     * Change title of site.
     * @static
     * @param $title
     */
    public static  function setTitle($title){
       $app = new Application();
       $app->sessionStart();
       $_SESSION["title"] = $title;
    }

    /**
     * Return controller name.
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
     * Return Controller Model.
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * After render.
     */
    protected function afterRender(){

    }

    /**
     * Before render.
     */
    protected function beforeRender(){

    }


}
