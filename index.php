<?php
require_once("config.php");


/** Class loading file with class, model etc. if its needed
 * @param $class_name
 */
function __autoload($class_name)
{
    if(strpos($class_name,"Controller"))
        require_once  BASE_DIR."controller/".$class_name.".php";
    else if(strpos($class_name,"Model"))
        require_once  BASE_DIR."model/".$class_name.".php";
    else
        require_once  BASE_DIR."admin/class/".$class_name.".php";
}

  if(isset($_GET["url"])){
$actions = $_GET["url"];
  }

$site = new SiteController();


