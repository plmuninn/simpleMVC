<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 11:00
 *
 */
?>
<fieldset>
    <legend>Dodaj użytkownika</legend>
    <form method="post" name="user">
        <label for="name">Imię: </label><input id="name" type="text" name="name"/><br/>
        <label for="surname">Nazwisko: </label><input id="surname" type="text" name="surname"/><br/>
        <label for="email">Email: </label><input id="email" type="text" name="email"/><br/>
        <label for="login">Login: </label><input id="login" type="text" name="login"/> <br/>
        <label for="password">Hasło: </label><input id="password" type="password" name="password"/><br/>
        <input type="button" value="Dodaj" class="submit" id="addUser" value='Save'/>
    </form>
</fieldset>


