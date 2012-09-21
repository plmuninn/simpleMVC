<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 28.04.12
 * Time: 21:27
 *
 */

if (isset($_GET["cat_id"])) {
    $cat = new CategoryModel();
    $cat = $cat->getById(array("id_category" => HTMLManager::cleanInput($_GET["cat_id"])));

    $topics = new TopicModel();
    $topics = $topics->getAllById(array("category_id_category" => HTMLManager::cleanInput($_GET['cat_id'])));


    if (isset($cat->id_category)) {

        echo "<table width='100%' id='forum'>";
        echo "<tr class='head'><td width='50%'>Temat</td><td>Autor</td><td>Ilość wiadomości</td><td>Stworzony</td><td>Ostatnia wiadomość</td></tr>";
        if (is_array($topics)) {
            foreach ($topics as $key => $value) {
                $usr = new UserModel();
                $usr = $usr->getById(array('id_user' => $value->user_id_user));
                $title = $value->title;
                $id = $value->id_topic;
                $created = $value->added_date;
                $post = new PostModel();
                $posts = $post->getAllById(array("topic_id_topic" => $id));
                $count = $post->query("SELECT COUNT(*) FROM post WHERE topic_id_topic =" . $id);
                $link = HTMLManager::makelink(array('href' => "topic&id_topic=" . $id . "&act=posts", 'link' => $title), false);
                ;
                $size = $count[0]["COUNT(*)"];
                $last = $posts[count($posts) - 1]->added_date;
                $time = $posts[count($posts) - 1]->added_time;
                $edit = '';

                if (Application::isAdmin() || Application::isOwner($usr->id_user)) {
                    $edit .= "<div class='edit-panel'>";
                    $edit .= HTMLManager::makeMenu(array(
                            array('href' => 'topic&act=edit&topic_id=' . $id, 'link' => 'Edytuj'),
                            array('href' => 'topic&act=remove&topic_id=' . $id, 'link' => 'Usuń'),
                        ),
                        false);
                    $edit .= "</div>";
                }


                echo "<tr>";
                echo "<td class='title'>$edit $link</td>";
                echo "<td class='size'>$usr->login</td>";
                echo "<td class='size'>$size</td>";
                echo "<td class='size'>$created</td>";
                echo "<td class='size'>$last | $time</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
        ?>
    <hr/>
    <div id="add">
        <?php echo
    HTMLManager::makeMenu(
        array(
            array("href" => "topic&act=add&cat_id=" . HTMLManager::cleanInput($_GET["cat_id"]), "link" => "Dodaj temat"),
        )
        , false
    );
        ?>
    </div>
    <?php
    } else {
        $_SESSION["error"] = array("type" => "error", "message" => "Brak takiej kategorii");
        $this->redirectToOther("", "");
    }
} else {
    $_SESSION["error"] = array("type" => "error", "message" => "Błędne dane");
    $this->redirectToOther("", "");
}

?>