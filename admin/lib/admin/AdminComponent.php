<?php
/**
 * Admin components mother class
 */

/**
 * Admin components mother class
 *
 * @package admin
 */

class AdminComponent extends Component
{
    public function __construct()
    {
        Application::sessionStart();
        parent::dependencies();
        $this->generateModels();
        Loader::import("plugins.*");
        Loader::import("components." . $this->name . ".plugins.*");
        parent::generateControllers();
        $this->app = new Application();
        $this->path = $this->app->getHomeUrl() . "admin/components/" . $this->component . "/";
        $this->dir = $this->app->getBaseDir() . "admin/components/" . $this->component;
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
     * Check if controller file exists.
     * @param string $name
     * @return bool
     */
    protected function checkController($name)
    {
        return file_exists(   $this->dir  . "/controller/" . $name . ".php");
    }

    /**
     *Method generate model if model exist.
     */
    protected function generateModels()
    {
        $className = get_class($this);
        $modelName = preg_replace("/Controller/", "", $className) . "Model";
        if (file_exists(Application::getBaseDir() . "admin/model/" . $modelName . ".php"))
            $this->model = new $modelName();
    }

    /**
     * Load module in view.
     * @param $name
     * @param array $values
     * @return Object
     */
    public function module($name, $values = array())
    {
        Loader::import("admin.modules." . strtolower($name) . ".*", "modules." . strtolower($name) . ".views.*");
        new $name($values);
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
        include_once($this->app->getBaseDir() . "admin/templates/" . $this->app->getTemplate() . "/index.php");
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

}
