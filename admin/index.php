<?php
require_once("../config.php");
require_once("class/Loader.php");
spl_autoload_register("Loader::autoload");
set_error_handler("Error::errorFunction");
set_exception_handler('Error::errorMessage');
Loader::import("admin.plugins.*");

if(function_exists('lcfirst') === false) {
    function lcfirst($str) {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}

new AdminController();

