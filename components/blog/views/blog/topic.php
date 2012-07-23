<?php

$topic = $this->model->getById(array("id_blog" => HTMLManager::cleanInput($_GET["blog_id"])));
$user = new UserModel();
$user = $user->getById(array("id_user"=>$topic->id_user));
echo "Autor: ".HTMLManager::makeLink(array("link"=>"<strong>".$user->login."</strong>", "href" =>"blog/account&comp=blog&user_id=".$user->id_user),false);
echo "<div class='short'>".$topic->short."</div>";
echo "<div class='long''>".$topic->long."</div>";