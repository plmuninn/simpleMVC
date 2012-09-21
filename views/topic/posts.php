<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 29.04.12
 * Time: 10:53
 *
 */

if (isset($_GET["id_topic"])) {

    $topic = new TopicModel();
    $topic = $topic->getById(array("id_topic" => HTMLManager::cleanInput($_GET["id_topic"])));

    $posts = new PostModel();
    $posts = $posts->getAllById(array("topic_id_topic" => HTMLManager::cleanInput($_GET["id_topic"])));

    if (isset($topic->id_topic)) {
        echo "<table width='100%' id='forum'>";
        echo "<tr class='head'><td>Autor</td><td width='85%'>Treść</td></tr>";
        if (is_array($posts)) {
            foreach ($posts as $key => $value) {
                $usr = new UserModel();
                $usr = $usr->getById(array('id_user' => $value->user_id_user));
                $id = $value->id_post;
                $post = $value->value;
                $date = $value->added_date;
                $time = $value->added_time;

                $edit = '';

                if (Application::isAdmin() || Application::isOwner($usr->id_user)) {
                    $edit .= "<div class='edit-panel'>";
                    $edit .= HTMLManager::makeMenu(array(
                            array('href' => 'post&act=edit&post_id=' . $id, 'link' => 'Edytuj'),
                            array('href' => 'post&act=remove&post_id=' . $id, 'link' => 'Usuń'),
                        ),
                        false);
                    $edit .= "</div>";
                }


                echo "<tr>";
                echo "<td class='size'><div class='login'>$usr->login</div><br /><div class='info'>dodał: <br />$date | $time</div> </td>";
                echo "<td class='title'>$edit $post</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        ?>

    <hr/>

    <?php
        echo HTMLManager::makeLink(array('link' => 'Dodaj wiadomość', 'href' => 'post&id_topic=' . HTMLManager::cleanInput($_GET["id_topic"]) . "&act=add"), false);

    } else {
        $_SESSION["error"] = array("type" => "error", "message" => "Brak takiego tematu");
        $this->redirectToOther("", "");
    }
} else {
    $_SESSION["error"] = array("type" => "error", "message" => "Błędne dane");
    $this->redirectToOther("", "");
}


?>