<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.07.12
 * Time: 17:13
 *
 */
$blog = $this->model->getAllById(array("id_user" => HTMLManager::cleanInput($_GET["user_id"])));
$user = new UserModel();
$user = $user->getById(array("id_user" => HTMLManager::cleanInput($_GET["user_id"])));
echo "<h1>" . $user->login . " Blog</h1>";
if (is_array($blog)) {
    echo "<ul>";
    foreach ($blog as $topic) {
        echo"<li>" . HTMLManager::makeLink(array("link" => $topic->short, "href" => "blog&comp=blog&blog_id=" . $topic->id_blog . "&act=topic"), false);
        if (Application::isOwner($topic->id_user)) {
            echo "<br /> " . HTMLManager::makeLink(array("link" => "Usuń", "href" => "admin&comp=blog&blog_id=" . $topic->id_blog . "&act=remove"), false) . " |";
            echo HTMLManager::makeLink(array("link" => " Edytuj", "href" => "admin&comp=blog&blog_id=" . $topic->id_blog . "&act=edit"), false);
        }
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Brak wiadomości";
}