<?php
require_once("../config.php");
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 14.04.12
 * Time: 12:00
 *
 */

Application::sessionStart();
/** Class loading file with class, model etc. if its needed
 * @param $class_name
 */
function __autoload($class_name)
{
    if(strpos($class_name,"Controller"))
    require_once BASE_DIR."admin/controller/".$class_name.".php";
    else if(strpos($class_name,"Model"))
    require_once BASE_DIR."model/".$class_name.".php";
    else
    require_once BASE_DIR."admin/class/".$class_name.".php";

}
   $actions = $_GET["url"];
   $admin = new AdminController();

