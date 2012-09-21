<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 11:41
 *
 */
?>
<fieldset>
    <legend>Rejestracja</legend>
    <form method="post">
        <label for="name">Imię: </label><input id="name" type="text" name="name"/><br/>
        <label for="surname">Nazwisko: </label><input id="surname" type="text" name="surname"/><br/>
        <label for="email">Email: </label><input id="email" type="text" name="email"/><br/>
        <label for="login">Login: </label><input id="login" type="text" name="login"/> <br/>
        <label for="password">Hasło: </label><input id="password" type="password" name="password"/><br/>
        <label for="password_repeat">Powtórz hasło: </label><input id="password_repeat" type="password"
                                                                   name="password_repeat"/><br/>
        <input type="submit" value="Zarejestruj" name="submit" class="submit"/>
    </form>
</fieldset>