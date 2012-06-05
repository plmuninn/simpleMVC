<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 24.04.12
 * Time: 22:56
 *
 */
?>
<div class="panel">

    <ul>
        <li><a href="<?php echo $app->getBaseUrl()."admin/index.php?url=admin/config"; ?>"><?php echo "<img src='".$app->getBaseUrl()."/img/Application.png'/><br />Ustawienia" ?></a></li>
        <li><a href="<?php echo $app->getBaseUrl()."admin/index.php?url=admin/user"; ?>"><?php echo "<img src='".$app->getBaseUrl()."/img/User.png'/><br />Użytkownicy"?></a></li>
        <li><a href="<?php echo $app->getBaseUrl()."admin/index.php?url=admin/kategorie"; ?>"><?php echo "<img src='".$app->getBaseUrl()."/img/Format Bullets.png'/><br />Kategorie"?></a></li>
        <li><a href="<?php echo $app->getBaseUrl()."admin/index.php?url=admin/tematy"; ?>"><?php echo "<img src='".$app->getBaseUrl()."/img/Bookmark.png'/><br />Tematy" ?></a></li>
        <!--<li><a href="<?php echo $app->getBaseUrl()."admin/index.php?url=admin/wiadomosci"; ?>"><?php echo "<img src='".$app->getBaseUrl()."/img/File New.png'/><br />Wiadomości"?></a></li>-->
    </ul>
</div>