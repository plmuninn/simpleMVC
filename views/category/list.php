<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:44
 *
 */

$categories = new CategoryModel();
$categories = $categories->getAll();
$classType = 0;


echo "<table id='categorys' width='100%'>";
echo "<tr class='head'><td>Nazwa</td><td>Opis</td><td>#</td><td>#</td></tr>";
foreach ($categories as $key => $value) {
    $editLink = HTMLManager::makelink(array('href' => "category&cat_id=" . $value->id_category . "&act=edit", 'link' => 'Edytuj'), false);
    $delink = HTMLManager::makelink(array('href' => "category&cat_id=" . $value->id_category . "&act=remove", 'link' => 'Usuń', 'class' => 'remove-category'), false);


    $class = ($classType != 1 ? 'first' : 'second');
    echo "<tr class='$class'>";
    echo "<td>$value->name</td>";
    echo "<td>$value->description</td>";
    echo "<td>$editLink</td>";
    echo "<td>$delink</td>";
    echo "</tr>";

    ($classType != 1 ? $classType++ : $classType = 0);
}
echo "</table>";