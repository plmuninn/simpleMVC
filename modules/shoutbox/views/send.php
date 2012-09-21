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

if (isset($_POST["user_id"]) && isset($_POST["message"])) {
    $user_id = $_POST["user_id"];
    $message = $_POST["message"];
    $shoutbox = new ShoutboxModel();
    $shoutbox->userModel->id_user = $user_id;
    $shoutbox->text = $message;
    $shoutbox->save();
} ?>
