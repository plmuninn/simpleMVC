<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<?php
$this->loadFile("shoutbox.css","css");
$this->loadFile("jquery.mCustomScrollbar.css","css");
$this->loadFile("shoutbox.js","javascript");
$this->loadFile("jquery.mousewheel.min.js","javascript");
$this->loadFile("jquery.mCustomScrollbar.js","javascript");
$usr = $_SESSION["user"];
?>
<a id="shoutbox_show" href="#">Pokaż shoutbox</a>
<div class="box" style="display: none">
    <p><h1>ShoutBox</h1></p>
    <div class="shoutbox">
      <div class="shout">
      </div>
     <input type="text" value="Wpisz wiadomość" name="shout_name" id="shout_message"  onblur="if (this.value == '') {this.value = 'Wpisz wiadomość';}" onfocus="if (this.value == 'Wpisz wiadomość') {this.value = '';}"/>
        <input type="hidden" value="<?php echo $usr->id_user ?>" name="shout_user" id="shout_user" />
    </div>
    <input type="button" value="Wyślij" id="shout_send" class="submit"/>
</div>