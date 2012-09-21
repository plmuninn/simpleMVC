<?php

$categories = new CategoryModel();
$categories = $categories->getAll();
echo "<table width='100%' id='forum'>";
echo "<tr class='head'><td  width='70%'>Tytuł</td><td>Ilość tematów</td></tr>";
if ($categories != null) {
    foreach ($categories as $key => $value) {
        $categoryLink = HTMLManager::makelink(array('href' => "category&cat_id=" . $value->id_category . "&act=topics", 'link' => $value->name), false);
        $topics = new TopicModel();
        $size = $topics->query("SELECT COUNT(*) FROM topic WHERE category_id_category ='$value->id_category'");
        $size = $size[0]["COUNT(*)"];
        echo"<tr>";
        echo"<td class='title'>$categoryLink<br />$value->description</td>";
        echo"<td class='size'>$size</td>";
        echo"</tr>";
    }
}
echo "</table>";

?>

