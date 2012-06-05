<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 10:58
 *
 */
if($app->isGuest())
    $this->redirectToOther("login");
else {
    $usr = $_SESSION["user"];
    $this->redirectToOther("user/account&us_id=$usr->id_user");}
