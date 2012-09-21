<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:43
 *
 */

if (isset($_GET["cat_id"])) {
    $cat = new CategoryModel();
    $cat = $cat->getById(array("id_category" => HTMLManager::cleanInput($_GET["cat_id"])));

    if (isset($cat->id_category)) {
        ?>
    <fieldset>
        <legend>Dodaj Temat</legend>
        <form method="post">
            <label for="name">Nazwa:</label><input type="text" name="name" id="name"/> <br/>
            <label>Treść:</label><textarea rows="10" cols="40" name="value"></textarea><br/>
            <input type="hidden" name="cat_id" value="<?php echo $_GET["cat_id"];?>"/>
            <input type="hidden" name="usr_id" value="<?php echo $_SESSION["user"]->id_user?>"/><br/>
            <input type="hidden" name="added_date" value="<?php echo Calendar::today() ?>"/>
            <input type="hidden" name="added_time" value="<?php echo Calendar::now() ?>"/>
            <input type="submit" name="add-topic" value="Dodaj" class="submit"/>
        </form>
    </fieldset>
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


