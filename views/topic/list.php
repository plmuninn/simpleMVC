<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:44
 *
 */

$usr = new UserModel();
$classType = 0;

$categories = new CategoryModel();
$categories = $categories->getAll();

$topic = new TopicModel();

foreach ($categories as $key => $value) {
    echo "<table width='100%'><tr class='head'><td><strong>$value->name</strong></tr></td></table>";
    echo "<table class='topics' width='100%'>";
    echo "<tr class='head'><td>Nazwa</td><td>Utworzył</td><td>#</td><td>#</td></tr>";
    $topics = $topic->getAllById(array("category_id_category" => $value->id_category));
    if (is_array($topics)) {
        foreach ($topics as $oneTopic) {

            $editLink = HTMLManager::makelink(array('href' => "topic&topic_id=" . $oneTopic->id_topic . "&act=edit", 'link' => 'Edytuj'), false);
            $delink = HTMLManager::makelink(array('href' => "topic&topic_id=" . $oneTopic->id_topic . "&act=remove", 'link' => 'Usuń', 'class' => 'remove-topic'), false);

            $usr = new UserModel();
            $usr = $usr->getById(array("id_user" => $oneTopic->user_id_user));
            $title = $oneTopic->title;

            $class = ($classType != 1 ? 'first' : 'second');
            echo "<tr class='$class'>";
            echo "<td>$title</td>";
            echo "<td>$usr->login</td>";
            echo "<td>$editLink</td>";
            echo "<td>$delink</td>";
            echo "</tr>";

            ($classType != 1 ? $classType++ : $classType = 0);
        }
    }

    $addLink = HTMLManager::makeLink(array('href' => "topic&cat_id=" . $value->id_category . "&act=add", 'link' => 'Dodaj temat'), false);

    echo "<tr class='foot'><td>$addLink</td></tr>";
    echo "</table>";
    echo "<br />";
}