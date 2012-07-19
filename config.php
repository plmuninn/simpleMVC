<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 12.04.12
 * Time: 21:44
 *
 */


/*Site configuration*/
define("SITE_PATH", $_SERVER["PHP_SELF"]);
define("BASE_DIR", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("SITE_TITLE","Radio Forum");
define("SITE_CHARSET", "utf-8");

/*Database configuration*/
define("DB_TYPE","mysql");
define("DB_NAME" ,"test");
define("DB_USER", "root");
define("DB_PASSWORD","zielone");
define("DB_ADDRES","localhost");
define("DB_CHARSET", "utf8");

/*
define("DB_TYPE","mysql");
define("DB_NAME" ,"loki_mvc");
define("DB_USER", "loki_loki");
define("DB_PASSWORD","zielone");
define("DB_ADDRES","localhost");
define("DB_CHARSET", "utf8");
*/

