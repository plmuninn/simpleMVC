<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 11:04
 *
 */
if($_GET["cat_id"] != null):
    $edit_category= $this->model->getById(array("id_category"=>HTMLManager::cleanInput($_GET["cat_id"])));
    ?>
<fieldset>
    <legend>Edytuj kategorię:</legend>
<form method="post">
    <input type="hidden" name="cat_id" value="<?php echo HTMLManager::cleanInput($_GET['cat_id'])?>"/>
    <label for="name">Nazwa: </label><input id="name" type="text" name="name" value="<?php echo $edit_category->name ;?>" /><br />
    <label for="description">Opis: </label><textarea id="description" name="description" rows="10" cols="27"><?php echo $edit_category->description ;?></textarea><br />
    <input type="submit" value="Zapisz" class="submit" name="cat-edit" />
</form>
</fieldset>
<?php
else:
    $this->redirectToOther("user"."list");
endif;