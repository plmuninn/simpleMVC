<?php
require_once("../../../bootstrap.php");
require_once("../models/ShoutboxModel.php");

if (isset($_POST["user_id"]) && isset($_POST["message"])) {
    $user_id = $_POST["user_id"];
    $message = $_POST["message"];
    $shoutbox = new ShoutboxModel();
    $shoutbox->user_id_user = $user_id;
    $shoutbox->text = $message;
    $shoutbox->save();
} ?>
