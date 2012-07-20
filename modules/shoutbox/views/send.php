<?php
require_once("../../../config.php");
require_once("../../../admin/class/Loader.php");
spl_autoload_register("Loader::autoload");
require_once("../models/ShoutboxModel.php");
var_dump($_POST);
$user_id = $_POST["user_id"];
$message = $_POST["message"];
$shoutbox = new ShoutboxModel();
$shoutbox->user_id_user = $user_id;
$shoutbox->text = $message;
$shoutbox->save();
