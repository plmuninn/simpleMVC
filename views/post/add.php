<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:43
 *
 */

if(isset($_GET["id_topic"])){

    $topic = new TopicModel();
    $topic = $topic->getById(array("id_topic" =>HTMLManager::cleanInput($_GET["id_topic"])));

    if(isset($topic->id_topic)){
?>

<fieldset>
    <legend>Dodaj wiadmość</legend>
      <form method="post">
      <input type="hidden" name="id_topic" value="<?php echo HTMLManager::cleanInput($_GET["id_topic"]);?>"/>
      <input type="hidden" name="added_date" value="<?php echo Calendar::today() ?>"/>
      <input type="hidden" name="added_time" value="<?php echo Calendar::now() ?>"/>
          <label>Treść:</label><textarea rows="10" cols="40" name="value"></textarea><br />
      <input type="submit" name="add-post" class="submit" value="Dodaj"/>
      </form>
</fieldset>


<?php
    }
else{
    $_SESSION["error"] = array("type"=>"error","message"=>"Brak takiego tematu");
    $this->redirectToOther("","");
}
}
else{
    $_SESSION["error"] = array("type"=>"error","message"=>"Błędne dane");
    $this->redirectToOther("","");
}

?>