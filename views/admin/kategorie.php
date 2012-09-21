<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 08:06
 *
 */

echo "<div class='list'>";
echo"<div class='showed'>";
include_once(Application::getBaseDir() . "views/category/list.php");
echo "</div>";
echo "</div>";
echo"<hr />";
echo "<p><a href='javascript:void(0)' id='show'>Pokaż</a> panel</p>";
echo "<div class='hide'>";
echo"<hr />";
include_once(Application::getBaseDir() . "views/category/add.php");
echo"</div>";
?>