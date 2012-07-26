<?php
/**
 * Plugin abstract class.
 */
/**
 * Class to implements plugin functions.
 * @package core
 * @subpackage controller
 */
abstract class Plugin
{
    /**
     * Method before renderer starts working. Good for changing size of photos in gallery.
     * @abstract
     */
    abstract public function beforeRender();

    /**
     * Method after renderer work out. Good for remove temp files.
     * @abstract
     */
    abstract public function afterRender();

    /**
     * Method before view was printed.
     * @abstract
     * @param string $content
     * @param string $controller_name
     * @param string $model
     */
    abstract public function beforeView(&$content, &$controller_name, &$model);

    /**
     * Method after view was printed.
     * @abstract
     */
    abstract public function afterView();

    /**
     * Method after model was saved.
     *  @abstract
     */
    abstract public function afterSave();

    /**
     * Method before model will be saved.
     *  @abstract
     */
    abstract public function beforeSave(&$model);
}
