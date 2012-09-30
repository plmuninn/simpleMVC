<?php
/**
 * Interface for Loader
 */
/**
 * Interface for Loader
 * @package interfaces
 */
interface LoaderInterface
{
    /**
     * Function auto-loading class files;
     * @static
     * @abstract
     * @param $class_name
     * @return mixed
     */
    public static function autoload($class_name);

    /**
     * Method importing files
     * @static
     * @abstract
     * @param $package
     * @param null $exceptions
     * @return mixed
     */
    public static function import($package, $exceptions = null);
}
