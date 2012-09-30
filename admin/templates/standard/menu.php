<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 19.04.12
 * Time: 12:17
 *
 */

if (!Application::isGuest()) {
    $usr = Application::loggedUser();
}

?>
<div class="user-menu">

    <?php
    if (Application::isGuest()) {
        echo HTMLManager::makeMenu(
            array(
                array("href" => "&comp=blog", "link" => "Blogi"),
                array("href" => "user&act=registration", "link" => "Rejestracja"),
                array("href" => "login", "link" => "Zaloguj"),
            )
            , false
        );
    } else {
        echo HTMLManager::makeMenu(
            array(
                array("href" => "", "link" => "Strona główna"),
            ), false
        );

        echo HTMLManager::makeMenu(
            array(
                array("href" => "user&act=logout", "link" => "Wyloguj"),
                array("href" => "user&act=account&us_id=$usr->id_user", "link" => "Twoje konto"),
                array("href" => "&comp=blog", "link" => "Blogi"),
                array("href" => "blog&act=account&comp=blog&user_id=$usr->id_user", "link" => "Twój blog"),
                array("href" => "admin&comp=blog", "link" => "Dodaj Wpis"),
                (Application::isAdmin() ? array("admin" => true, "href" => "", "link" => "Panel Admina") : array()),
            ), false
        );
    }
    ?>
</div>
<hr/>
