<?php
require_once("../config.php");
require_once("lib/Loader.php");
spl_autoload_register("Loader::autoload");
set_error_handler("Error::errorFunction");
set_exception_handler('Error::errorMessage');


if (function_exists('lcfirst') === false) {
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}


Loader::import("admin.lib.admin.interfaces.*");
Loader::import("admin.lib.admin.*");
Loader::import("admin.plugins.*");
Loader::import("admin.models.*");
Loader::import("admin.controller.*");



new AdminController();

