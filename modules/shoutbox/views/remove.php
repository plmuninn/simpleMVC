<?php
require_once("../../../bootstrap.php");
require_once("../models/ShoutboxModel.php");

if (isset($_POST["shout_id"])) {
    $shout = new ShoutboxModel();
    $shout->removeById(array("id_shoutbox" => $_POST["shout_id"]));
}
?>