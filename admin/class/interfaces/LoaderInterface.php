<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 19.07.12
 * Time: 08:27
 *
 */
interface LoaderInterface
{
    /**Function auto-loading class files;
     * @static
     * @abstract
     * @param $class_name
     * @return mixed
     */
    public static function autoload($class_name);

    /***Method importing files
     * @static
     * @abstract
     * @param $package
     * @return mixed
     */
    public static function import($package, $exceptions = null);
}
