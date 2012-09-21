<?php
require_once("../config.php");
require_once("class/Loader.php");
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


/*
Loader::import("admin.plugins.*");
Loader::import("admin.models.*");
Loader::import("admin.controller.*");
*/

Loader::import("admin.class.admin.interfaces.*");
Loader::import("admin.class.admin.*");


new Admin();

