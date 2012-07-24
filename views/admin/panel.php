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
        <li><a href="<?php echo $this->app->getHomeUrl()."admin/index.php?cont=admin&act=config"; ?>"><?php echo "<img src='".$this->app->getHomeUrl()."/img/Application.png'/><br />Ustawienia" ?></a></li>
        <li><a href="<?php echo $this->app->getHomeUrl()."admin/index.php?cont=admin&act=user"; ?>"><?php echo "<img src='".$this->app->getHomeUrl()."/img/User.png'/><br />Użytkownicy"?></a></li>
        <li><a href="<?php echo $this->app->getHomeUrl()."admin/index.php?cont=admin&act=kategorie"; ?>"><?php echo "<img src='".$this->app->getHomeUrl()."/img/Format Bullets.png'/><br />Kategorie"?></a></li>
        <li><a href="<?php echo $this->app->getHomeUrl()."admin/index.php?cont=admin&act=tematy"; ?>"><?php echo "<img src='".$this->app->getHomeUrl()."/img/Bookmark.png'/><br />Tematy" ?></a></li>
        <!--<li><a href="<?php echo $this->app->getHomeUrl()."admin/index.php?cont=admin&act=wiadomosci"; ?>"><?php echo "<img src='".$this->app->getHomeUrl()."/img/File New.png'/><br />Wiadomości"?></a></li>-->
    </ul>
</div>