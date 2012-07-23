<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.07.12
 * Time: 17:03
 *
 */
$models = $this->model->getAll();
if(count($models) >0){
    echo "<ul>";
    $users = new UserModel();
    $users = $users->getAll();
    foreach($users as $user){
         $blog = $this->model->getUserLast($user->id_user);
            if(is_object($blog)){
              echo "<li>";
              echo "<div class='user'>Napisane przez :".HTMLManager::makeLink(array("link"=>"<strong>".$user->login."</strong>", "href" =>"blog/account&comp=blog&user_id=".$user->id_user),false)."</div>";
              echo "<div class='short'>".$blog->short."</div>";
              echo "<div class='more'>".HTMLManager::makeLink(array("link"=>"Więcej", "href" =>"blog/topic&comp=blog&blog_id=".$blog->id_blog),false)."</div>";
              echo "</li>";
            }
    }
    echo "</ul>";
}
else{
    echo "<p>Brak blogów :(</p>";
}