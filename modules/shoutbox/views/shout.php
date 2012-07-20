<?php
require_once("../../../config.php");
require_once("../../../admin/class/Loader.php");
spl_autoload_register("Loader::autoload");
require_once("../models/ShoutboxModel.php");

$users = new UserModel();
$users = $users->getAll();
$shoutbox = new ShoutboxModel();
$shoutbox = $shoutbox->getAll();
$shoutbox = array_reverse($shoutbox);

echo"<ul>";
if(count($shoutbox)>0){
    foreach($shoutbox as $value){
        foreach ($users as $user){
            if($value->user_id_user == $user->id_user){
               echo "<li>".$user->login." : ".$value->text."</li>";
            }
        }
    }
}
else{
    echo "<li>Brak wiadomości</li>";
}
echo"</ul>";
