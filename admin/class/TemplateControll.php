<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 14.04.12
 * Time: 12:18
 *
 */

/*Controller class manage all views and actions and render site
*
*
*  */
class TemplateControll {


    protected $controllers = array();
    protected $functions = array();
    protected $model;
    protected $rendered = false;
    protected $others = array();
    protected $name;
    protected $content;
    protected $message = array();

    private $app;
    private $file;

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
      if($this->controllers[0] == strtolower(preg_replace("/Controller/","",get_class($this)))){
        $this->rendered = true;
        $this->renderIndex();
       }


        /*If don't find any controller or action*/
        if(!$this->rendered){
          throw new Exception("Site don't found.");
        }

    }

    function __destruct()
    {
      Application::sessionWrite();
    }


    /**Render view. $name must have that same value like file name in view folder
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

    protected function renderIndex(){
       $this->render("index");
    }

    /**Check if controller exist
     * @param string $name
     * @return bool
     */
    protected  function checkController($name){
        return file_exists(Application::getBaseDir()."controller/".$name.".php");
    }


    /**Function redirect to other controller.
     * @return bool
     */
    protected function redirect(){
        foreach($this->controllers as $key =>$value){
            $name = ucfirst($value)."Controller";
            if($this->checkController($name)){
                $site = new $name();
                return true;
            }
        }
        return false;
    }

    /**Method check and activate action*/
    protected  function functionsCheck(){
        foreach($this->controllers as $key => $value){
            if(in_array($value."Render",$this->functions) && !$this->rendered){
                $name = $value."Render";
                $this->$name();
                $this->rendered = true;
            }
        }
    }

    /**Change location to other view
     * @param string $view
     * @param bool $admin for admin site true
     */
    protected function redirectToOther($view, $admin){
        $app = new Application();
        header('Location: '.$app->getHomeUrl().($admin == false ? "index.php?url=" : "admin/index.php?url=").$view."");
        exit();
    }

     /**Generate view*/
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
     *Method generate all controllers and add it to class array
     */
    protected function generateControllers(){
        self::generateName();
        global $actions;
        $this->functions = get_class_methods($this);
        $this->controllers = explode("/",$actions);
        $this->controllers = array_reverse($this->controllers);
        $this->controllers = array_filter($this->controllers, 'strlen');
        $this->functionsCheck();
        unset($_GET["url"]);

    }

    /**
     *Method generate model if model exist
     */
    protected function generateModels(){
        $className = get_class($this);
        $modelName = preg_replace("/Controller/","",$className)."Model";
        if(file_exists(Application::getBaseDir()."model/".$modelName.".php"))
            $this->model = new $modelName();
    }

    /**
     *Method set name of object from controller
     */
    protected function generateName(){
        $className = get_class($this);
        $this->name = preg_replace("/Controller/","",$className);
        $this->name  = strtolower($this->name);
    }


    /**Change title of site
     * @static
     * @param $title
     */
    public static  function setTitle($title){
       $app = new Application();
       $app->sessionStart();
       $_SESSION["title"] = $title;
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function afterRender(){

    }

    protected function beforeRender(){

    }


}
