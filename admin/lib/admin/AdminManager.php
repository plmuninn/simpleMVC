<?php

/**
 * Admin controller mother class
 */

/**
 * Admin controller mother class
 *
 * @package admin
 */



class AdminManager extends Controller
{

    function __construct()
    {
        Application::sessionStart();
        $this->generateName();
        Loader::import("admin.plugins.*");
        $this->generateModels();
        $this->generateControllers();

        /*If index controller*/
        if (!isset($this->component)) {
            if ($this->controllers == strtolower(preg_replace("/Controller/", "", get_class($this))) || is_null($this->controllers)) {
                if (is_null($this->actions)) {
                    $this->rendered = true;
                    $this->actionIndex();
                }
            }
        } else {
            $this->redirectComponent();
        }

        /*If don't find any controller or action*/
        if (!$this->rendered) {
            throw new Exception("Site don't found.");
        }

    }

    /**
     *Method redirect to component class.
     */
    protected function redirectComponent()
    {
        if (file_exists(Application::getBaseDir() . "admin/components/" . strtolower($this->component))) {
            Loader::import("admin.components." . strtolower($this->component) . ".*", "admin/components." . strtolower($this->component) . ".views.*");
            if (file_exists(Application::getBaseDir() . "admin/components/" . strtolower($this->component) . "/controller/" . ucfirst($this->component) . "Controller.php")) {
                $class = Loader::checkClassName(Application::getBaseDir() . "admin/components/" . strtolower($this->component) . "/controller/" . ucfirst($this->component) . "Controller.php", $this->component . "Controller");
                if ($class) {
                    $name = ucfirst($this->component) . "Controller";
                    new $name;
                } else
                    throw new Exception("Component " . $this->component . " don't have a controller class or file structure is bad!");
            } else
                throw new Exception("Component " . $this->component . " don't have a controller file!");

            $this->rendered = true;
        } else
            throw new Exception("Component " . $this->component . " not found");
    }


    public function render($name)
    {
        if (!is_object($this->plugins))
            $this->plugins = new PluginManager();
        $this->beforeRender();
        /*Create instance of application configurations and make it global*/
        $this->app = new Application();
        /*Get view*/
        $this->file = $this->app->getBaseDir() . "admin/views/" . $this->name . "/" . $name . ".php";
        /*Get template*/
        include_once($this->app->getBaseDir() . "admin/templates/" . $this->app->getTemplate() . "/index.php");
        $this->afterRender();

    }

    /**
     * Generate view.
     */
    private function view()
    {
        if (file_exists($this->file)) {
            ob_start();
            require_once($this->file);
            $contents = ob_get_contents();
            $this->beforeView($contents, $this->name, $this->model);
            ob_end_clean();
            echo $contents;
            $this->afterView(array());
        } else
            trigger_error("No view" . $this->actions . " in ".$this->name, E_USER_ERROR);
    }


}
