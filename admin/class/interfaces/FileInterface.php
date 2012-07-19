<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 30.05.12
 * Time: 21:52
 *
 */
interface FileInterface
{
    /**Create folder if not exits. Name of folder should be at end of $path
     * @static
     * @abstract
     * @param string $path
     * @return bool
     */
    public static function  createFolder($path);

    /**Remove folder if exits. Name of folder should be at end of $path
     * @static
     * @abstract
     * @param string $path
     * @return bool
     * @throws Exception
     */
    public static function  removeFolder($path);

    /**Create file on $path
     * @static
     * @abstract
     * @param string $path
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public static function  createFile($path, $name);

    /**Remove file on $path
     * @static
     * @abstract
     * @param string $path
     * @param string $name
     * @return bool
     */
    public static function  removeFile($path, $name);

    /**Get all folders ona $path
     * @static
     * @abstract
     * @param string $path
     * @return array
     * @throws Exception
     */
    public static function  getFolders($path);

    /**Get all files from $path
     * @static
     * @abstract
     * @param string $path
     * @return array
     * @throws Exception
     */
    public static function getFiles($path);

    /**Return all files and folders in directory
     * @static
     * @abstract
     * @param string $path
     * @return array
     * @throws Exception
     */
    public static function getAll($path);
}
