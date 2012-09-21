<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:43
 *
 */
?>

<fieldset>
    <legend>Dodaj kategorię</legend>
    <form method="post">
        <label for="name">Nazwa:</label><input id="name" type="text" name="name"/><br/>
        <label for="description">Opis: </label><textarea id="description" name="description" rows="10"
                                                         cols="27"></textarea><br/>
        <input type="button" value="Dodaj" class="submit" id="addCategory" value='Save'/>
    </form>
</fieldset>