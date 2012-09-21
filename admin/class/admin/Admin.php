<?php

class Admin extends Component
{
    public function __construct()
    {
        Application::sessionStart();
        $this->name = 'Admin';
        parent::dependencies();
        $this->generateModels();
        Loader::import("plugins.*");
        Loader::import("components." . $this->name . ".plugins.*");
        parent::generateControllers();
        $this->component = 'admin';
        $this->app = new Application();
        $this->path = $this->app->getHomeUrl() . "admin/components/" . $this->component . "/";
        $this->dir = $this->app->getBaseDir() . "admin/components/" . $this->component . "/";
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

}
