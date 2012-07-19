<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 19.04.12
 * Time: 07:22
 *
 */

/**Interface for HTMLManager class */
interface HTMLInterface
{

    /** Method create link (<a></a> tag)
     * @static
     * @abstract
     * @param array $values
     * @param bool $admin
     * @return mixed
     */
    public static function makeLink($values = array(), $admin);

    /** Method create image tag (<img />)
     * @static
     * @abstract
     * @param array $values
     * @return mixed
     */
    public static function makeImage($values = array());

    /** Method clear string, protect SqlInjection
     * @static
     * @abstract
     * @param $input
     * @return mixed
     */
    public static function cleanInput($input);

    /** Method create menu like a list (<ul></ul>)
     * @static
     * @abstract
     * @param array $values
     * @param bool $admin
     * @return mixed
     */
    public static function makeMenu($values = array(), $admin);

    /** Method create <select></select> tag
     * @static
     * @abstract
     * @param array $array
     * @return mixed
     */
    public static function makeSelect($array = array());

}
