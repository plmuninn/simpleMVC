<?php
require_once("../../../config.php");
require_once("../../../admin/class/Loader.php");
spl_autoload_register("Loader::autoload");
require_once("../models/ShoutboxModel.php");

if (function_exists('lcfirst') === false) {
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}

if (isset($_POST["shout_id"])) {
    $shout = new ShoutboxModel();
    $shout->removeById(array("id_shoutbox" => $_POST["shout_id"]));
}
?>