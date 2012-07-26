<?php
/**
 * Plugin manager.
 */
/**
 * Class to manage a plugins in all MVC and Components.
 * @package core
 * @subpackage controller
 */
class PluginManager
{

    /**
     * Method before renderer starts working. Good for changing size of photos in gallery.
     * @static
     */
    public static function beforeRender()
    {

            $classes = get_declared_classes();
            foreach($classes as $class){
                if(get_parent_class($class) == "Plugin"){
                    $obj = new $class;
                    call_user_func(array($obj,__FUNCTION__));
                }
            }

    }

    /**
     * Method after renderer work out. Good for remove temp files.
     * @static
     */
    public static function afterRender()
    {
            $classes = get_declared_classes();
            foreach($classes as $class){
                if(get_parent_class($class) == "Plugin"){
                    $obj = new $class;
                    call_user_func(array($obj,__FUNCTION__));
                }
            }
    }

    /**
     * Method before view was printed.
     * @static
     * @param $content
     * @param $controller_name
     * @param $model
     * @return mixed
     */
    public static function beforeView(&$content, &$controller_name, &$model)
    {

            $classes = get_declared_classes();
            foreach($classes as $class){
                if(get_parent_class($class) == "Plugin"){
                    $obj = new $class;
                    call_user_func_array(array($obj,__FUNCTION__), array(&$content, &$controller_name, &$model));
                }
            }

    }

    /**
     * Method after view was printed.
     * @static
     */
    public static function afterView()
    {
            $classes = get_declared_classes();
            foreach($classes as $class){
                if(get_parent_class($class) == "Plugin"){
                    $obj = new $class;
                    call_user_func(array($obj,__FUNCTION__));
                }
            }
    }

    /**
     * Method after model was saved.
     * @static
     */
    public static function afterSave()
    {
        $classes = get_declared_classes();
        foreach($classes as $class){
            if(get_parent_class($class) == "Plugin"){
                $obj = new $class;
                call_user_func(array($obj,__FUNCTION__));
            }
        }
    }

    /**
     * Method before model will be saved.
     * @static
     */
    public static function beforeSave(&$model)
    {
        $classes = get_declared_classes();
        foreach($classes as $class){
            if(get_parent_class($class) == "Plugin"){
                $obj = new $class;
                call_user_func_array(array($obj,__FUNCTION__),array(&$model));
            }
        }
    }

}
