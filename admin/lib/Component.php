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
    protected $path;

    /**
     * File loader value
     * @var string
     */
    protected $dir;

    /**
     *Constructor check url and active controller and actions from them.
     * @throws Exception
     */
    public function __construct()
    {
        Application::sessionStart();
        parent::getName();
        parent::dependencies();
        $this->app = new Application();
        $this->path = $this->app->getHomeUrl() . "components/" . $this->component . "/";
        $this->dir = $this->app->getBaseDir() . "components/" . $this->component;
        $this->generateModels();
        Loader::import("plugins.*");
        Loader::import("components." . $this->name . ".plugins.*");
        parent::generateControllers();
        if (($this->controllers == null) || ($this->controllers == strtolower(preg_replace("/Controller/", "", get_class($this))))) {
            $this->rendered = true;
            $this->actionIndex();
        } else {
            $this->redirect();
        }

        /*If don't find any controller or action*/
        if (!$this->rendered) {
            throw new Exception("Site don't found.");
        }
    }


    /**
     *Method generate model if model exist.
     */
    protected function generateModels()
    {
        $className = get_class($this);
        $modelName = preg_replace("/Controller/", "", $className) . "Model";
        if (file_exists($this->dir . "/model/" . $modelName . ".php"))
            $this->model = new $modelName();
    }

    /**
     * Render view. $name must have that same value like file name in view folder.
     * @param string $name
     */
    public function render($name)
    {
        if (!is_object($this->plugins))
            $this->plugins = new PluginManager();
        $this->beforeRender();
        /*Get view*/
        $this->app = new Application();
        $this->file = $this->dir . "/views/" . $this->name . "/" . $name . ".php";
        /*Get template*/
        include_once($this->app->getBaseDir() . "templates/" . $this->app->settings('template') . "/index.php");
        $this->afterRender();
    }

    /**
     * Generate view
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
            $this->afterView();
        } else
            throw new Exception("View file " . $this->file . ' not found.');
    }


    /**
     * Load css and js files
     * @param null $path
     * @param null $name
     * @param null $type
     */
    protected function loadFile($path = null, $name = null, $type = null)
    {
        switch ($type) {
            case "css":
                if ($path == null)
                    echo "<link rel='stylesheet' type='text/css' href='" . $this->path . "css/" . $name . "' />";
                else
                    echo "<link rel='stylesheet' type='text/css' href='" . $path . $name . "' />";
                break;
            case "javascript":
                if ($path == null)
                    echo "<script src='" . $this->path . "js/" . $name . "' type='text/javascript' charset='utf-8'></script>";
                else
                    echo "<script src='" . $path . $name . "' type='text/javascript' charset='utf-8'></script>";
                break;
            case "js":
                if ($path == null)
                    echo "<script src='" . $this->path . "js/" . $name . "' type='text/javascript' charset='utf-8'></script>";
                else
                    echo "<script src='" . $path . $name . "' type='text/javascript' charset='utf-8'></script>";
                break;
            case null:
                if ($path != null && $name != null) {
                    $file_info = $name;
                    $mime_type = explode(".", $name);
                    switch ($mime_type[count($mime_type) - 1]) {
                        case"css";
                            echo "<link rel='stylesheet' type='text/css' href='" . $path . $name . "' />";
                            break;
                        case"js";
                            echo "<script src='" . $path . $name . "' type='text/javascript' charset='utf-8'></script>";
                            break;
                    }
                } elseif ($path != null && $name == null) {
                    $file_info = $name;
                    $mime_type = explode(".", $path);
                    switch ($mime_type[count($mime_type) - 1]) {
                        case"css";
                            echo "<link rel='stylesheet' type='text/css' href='" . $path . "' />";
                            break;
                        case"js";
                            echo "<script src='" . $path . "' type='text/javascript' charset='utf-8'></script>";
                            break;
                    }
                }
                break;
        }
    }

    /**
     * Check if controller file exists.
     * @param string $name
     * @return bool
     */
    protected function checkController($name)
    {
        return file_exists($this->dir . "/controller/" . $name . ".php");
    }

}
