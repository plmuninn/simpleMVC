<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 11:04
 *
 */
if($_GET["us_id"] != null):
    $edit_user = $this->model->getById(array("id_user" => HTMLManager::cleanInput($_GET["us_id"])));
    ?>
<form method="post">
    <input type="hidden" name="us_id" value="<?php echo $_GET['us_id']?>"/>
    <label for="name">Imię: </label><input id="name" type="text" name="name" value="<?php echo $edit_user->name ;?>" /><br />
    <label for="surname">Nazwisko: </label><input id="surname" type="text" name="surname" value="<?php echo $edit_user->surname ;?>" /><br />
    <label for="email">Email: </label><input id="email" type="text" name="email" value="<?php echo $edit_user->email ;?>" /><br />
    <label for="login">Login: </label><input id="login" type="text" name="login" value="<?php echo $edit_user->login ;?>" /> <br />
    <label for="password">Hasło: </label><input id="password" type="password" name="password" value="" /><br />
    <input type="submit" value="Zapisz" class="submit" name="user-edit" />
</form>
<?php
else:
    $this->redirectToOther("user/list");
endif;