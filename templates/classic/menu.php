<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 19.04.12
 * Time: 12:17
 *
 */

if(!Application::isGuest()){
$usr = $_SESSION["user"];}

?>
<div class="user-menu">

<?php
    if(Application::isGuest()){
        echo HTMLManager::makeMenu(
            array(
                array("href" =>"user/registration", "link" =>"Rejestracja"),
                array("href" =>"login", "link" =>"Zaloguj"),
            )
        , false
        );
    }
    else{
        echo HTMLManager::makeMenu(
            array(
                array("href" =>"", "link" =>"Strona główna"),
            ), false
        );

        echo HTMLManager::makeMenu(
            array(
                array("href" =>"user/account&us_id=$usr->id_user", "link" =>"Twoje konto"),
                array("href" =>"user/logout", "link" =>"Wyloguj"),
                (Application::isAdmin() ? array("admin" => true,"href" =>"", "link" =>"Panel Admina") : array()),
            ), false
        );
    }
                    ?>
</div>
<hr/>
