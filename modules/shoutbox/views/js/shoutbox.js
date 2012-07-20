
$(document).ready(function() {

    var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";
    if(location.hostname == "localhost"){
        url += "simpleMVC/"
    }
    $(".shout").append("<div class='shoutbox_loader'><img src='"+url+"modules/shoutbox/views/img/ajax-loader.gif' /></div>");

    loadShoutbox();

    $("#shout_send").click(function(){
        if($("#shout_message").val() != 'Wpisz wiadomość'){
            var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";
            if(location.hostname == "localhost"){
                url += "simpleMVC/"
            }
            $.ajax({
                url: url +"modules/shoutbox/views/send.php" ,
                type: "POST",
                data: {user_id: $("#shout_user").val(), message:$("#shout_message").val()}
            }).done(function(data){
                    $("#shout_message").val("Wpisz wiadomość");
                   loadShoutbox();
                });
        }

    });

});

function loadShoutbox(){
    var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";

    if(location.hostname == "localhost"){
        url += "simpleMVC/"
    }

    $.ajax({
        url: url +"modules/shoutbox/views/shout.php"
    }).done(function(data){
            $(".shout").empty();
            $(".shout").append(data);
            $(".shout").mCustomScrollbar();
            $(".shout_remove").find('a').click(function(event){
                event.stopPropagation();

                var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";
                if(location.hostname == "localhost"){
                    url += "simpleMVC/"
                }

                $.ajax({
                    url: url +"modules/shoutbox/views/remove.php" ,
                    type: "POST",
                    data: {shout_id: $(this).attr("href")}
                }).done(function(data){
                        loadShoutbox();
                    });
                return false;
            });
        });
}