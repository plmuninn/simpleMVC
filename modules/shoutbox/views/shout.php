<?php
require_once("../../../bootstrap.php");
require_once("../models/ShoutboxModel.php");

$users = new UserModel();
$users = $users->getAll();
$shoutbox = new ShoutboxModel();
$shoutbox = $shoutbox->getAll();
$shoutbox = array_reverse($shoutbox);

echo"<ul>";
if (count($shoutbox) > 0) {
    foreach ($shoutbox as $value) {
        foreach ($users as $user) {
            if ($value->user_id_user == $user->id_user) {
                echo "<li><strong>" . $user->login . " :</strong> " . $value->text . "<div class='shout_remove'><a href='" . $value->id_shoutbox . "'>x</a></div></li>";
            }
        }
    }
} else {
    echo "<li>Brak wiadomości</li>";
}
echo"</ul>"; ?>