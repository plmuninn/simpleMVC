<?php
require_once("config.php");
require_once("admin/class/Loader.php");
spl_autoload_register("Loader::autoload");
new SiteController();

