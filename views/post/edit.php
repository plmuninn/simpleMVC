<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:43
 *
 */

if(isset($_GET["post_id"])){

    $post = new PostModel();
    $post= $post->getById(array("id_post" =>HTMLManager::cleanInput($_GET["post_id"])));

    if(isset($post->id_post)){
        ?>

    <fieldset>
        <legend>Edytuj wiadomość</legend>
        <form method="post">
            <input type="hidden" name="id_post" value="<?php echo HTMLManager::cleanInput($_GET['post_id']);?>" />
            <label>Treść</label><textarea rows="10" cols="40" name="value"><?php echo $post->value?></textarea><br />
            <input type="submit" name="save-post" class="submit" value="Zapisz"/>
        </form>
    </fieldset>

    <?php
    }
    else{
        $_SESSION["error"] = array("type"=>"error","message"=>"Brak takiej wiadomości");
        $this->redirectToOther("",false);
    }
}
else{
    $_SESSION["error"] = array("type"=>"error","message"=>"Błędne dane");
    $this->redirectToOther("",false);
}

?>