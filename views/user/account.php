<?php
if ($_GET["us_id"] != null):
    $edit_user = $this->model->getById(array("id_user" => HTMLManager::cleanInput($_GET["us_id"])));?>
<div class="showed">
    <fieldset>
        <legend>Twoje dane</legend>
        <form method="post">
            <input type="hidden" name="us_id" value="<?php echo $_GET['us_id']?>"/>
            <label for="name">Imię: </label><input id="name" type="text" name="name"
                                                   value="<?php echo $edit_user->name;?>"/><br/>
            <label for="surname">Nazwisko: </label><input id="surname" type="text" name="surname"
                                                          value="<?php echo $edit_user->surname;?>"/><br/>
            <label for="email">Email: </label><input id="email" type="text" name="email"
                                                     value="<?php echo $edit_user->email;?>"/><br/>
            <label for="login">Login: </label><input id="login" type="text" name="login"
                                                     value="<?php echo $edit_user->login;?>"/> <br/>
            <input type="submit" value="Zapisz" name="user-save" class="submit"/>
        </form>
    </fieldset>
</div>
<hr/>
<p><a href="javascript:void(0)" id="show">Pokaż</a> Zmianę hasła</p>
<div class="hide">
    <hr/>
    <fieldset>
        <legend>Edycja hasła</legend>
        <form method="post">
            <input type="hidden" name="us_id" value="<?php echo $_GET['us_id']?>"/>
            <label for="password">Hasło: </label><input id="password" type="password" name="password" value=""/><br/>
            <label for="password_repeat">Powtórz hasło: </label><input id="password_repeat" type="password"
                                                                       name="password_repeat" value=""/><br/>
            <input type="submit" value="Zapisz hasło" name="password-save" class="submit"/>
        </form>
    </fieldset>
</div>
<?php
endif; ?>