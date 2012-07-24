<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.04.12
 * Time: 09:56
 *
 */


$users = new UserModel();
$users =$users->getAll();
$classType = 0;

echo "<div class='list'>";
echo"<div class='showed'>";
echo "<table id='users' width='100%'>";
echo "<tr class='head'><td>Login</td><td>Mail</td><td>Imię</td><td>Nazwisko</td><td>#</td><td>#</td></tr>";
foreach($users as $key => $value){
    $editLink = HTMLManager::makelink(array('href'=>"user&us_id=".$value->id_user."&act=edit" , 'link'=>'Edytuj' ),false);
    $delink = HTMLManager::makelink(array('href'=>"user&us_id=".$value->id_user."&act=remove", 'link'=>'Usuń', 'class'=>'remove-user'), false);
    $class = ($classType !=1 ? 'first' : 'second');


    echo "<tr class='$class'>";
    echo "<td>$value->login</td>";
    echo "<td>$value->email</td>";
    echo "<td>$value->name</td>";
    echo "<td>$value->surname</td>";
    echo "<td>$editLink</td>";
    echo "<td>$delink</td>";
    echo "</tr>";

    ($classType !=1 ? $classType++ : $classType= 0);
}
echo "</table>";
echo "</div>";
echo "</div> ";
echo"<hr />";
echo "<p><a href='javascript:void(0)' id='show'>Pokaż</a> panel</p>";
echo "<div class='hide'>";
echo"<hr />";
include_once("create.php");
echo"</div>";