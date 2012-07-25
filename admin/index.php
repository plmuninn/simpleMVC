<?php
require_once("../config.php");
require_once("class/Loader.php");
spl_autoload_register("Loader::autoload");
set_error_handler("Error::errorFunction");
set_exception_handler('Error::errorMessage');
new AdminController();

