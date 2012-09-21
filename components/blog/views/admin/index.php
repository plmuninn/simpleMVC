<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.07.12
 * Time: 17:02
 *
 */
if (isset($_GET["blog_id"]) && !empty($_GET["blog_id"])) {
    $topic = new BlogModel();
    $topic = $topic->getById(array("id_blog" => HTMLManager::cleanInput($_GET["blog_id"])));
}
?>
<fieldset>
    <legend>Dodaj wpis</legend>
    <form method="post" action="<?php echo $this->app->getHomeUrl()?>index.php?cont=admin&act=add&comp=blog">
        <input type="hidden" name="id_user" value="<?php echo Application::loggedUser()->id_user?>"/>
        <input type="hidden" name="blog_id" value="<?php echo (isset($topic) ? $topic->id_blog : ""); ?>"/>
        <label>Treść krótka:</label><textarea rows="5" cols="40"
                                              name="short"><?php echo (isset($topic) ? $topic->short : ""); ?></textarea><br/>
        <label>Treść długa:</label><textarea rows="10" cols="40"
                                             name="long"><?php echo (isset($topic) ? $topic->long : ""); ?></textarea><br/>
        <input type="submit" name="add-post" class="submit"
               value="<?php echo (isset($topic) ? "Zapisz" : "Dodaj"); ?>"/>
    </form>
</fieldset>
