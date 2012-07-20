<?php
require_once("../config.php");
require_once("class/Loader.php");
spl_autoload_register("Loader::autoload");

$actions = $_GET["url"];
$admin = new AdminController();

