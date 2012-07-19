/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 18.04.12
 * Time: 20:21
 *
 */

$(document).ready(function() {

    var dataVisable = true;

    $('.message').delay(2000).slideUp('slow');
    $('.error').delay(2000).slideUp('slow');
    $('.warning').delay(2000).slideUp('slow');

    /*Pokazanie panelu do zmiany hasła*/
    $('#show').click(function() {

        /*Zjeżdzamy na sam doł strony*/
        $("html").animate({ scrollTop:$(document).height() }, "slow");

        /*Zamieniamy*/
        $('div.hide').slideToggle('slow');

        /*Wystawiamy flagę*/
        if(dataVisable == false){
              dataVisable = true
            $(this).text("Pokaż");
        }
        else{
            dataVisable = false;
            $(this).text("Ukryj");
        }

    });


    users();
    categories();
    topics();

    var addUs = document.getElementById('addUser');
    if(addUs != null){
         addUs.addEventListener('click',addUser,false);
    }

    var saveConf = document.getElementById('saveConfig')
    if(saveConf != null){
              saveConf.addEventListener('click',saveConfig,false);
    }

    var addCat = document.getElementById('addCategory')
    if(addCat != null){
          addCat.addEventListener('click',addCategory,false);
    }



});

function removeUser(object){

    object.preventDefault();
    object.stopPropagation();


    var ajax = ajaxOpen();

    function processResponse()
    {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var obj = eval('(' + ajax.responseText + ')');
                    if(typeof(obj.messages) != 'undefined'){
                        $('.systemMessage').html("<div class='message'>"+obj.messages+"</div>");
                        $('.message').delay(2000).slideUp('slow');

                        var table = document.getElementById("users");
                        var lenght = table.rows.length;

                        for(var i =0 ; i < lenght; i++){
                            var rows = table.rows[i].cells.length;

                            for(var i2= 0; i2 < rows; i2++){
                                if(table.rows[i].cells[i2].innerHTML.replace(/\&amp;/g,'&').indexOf(object.target.href) != -1){
                                    table.deleteRow(i);
                                }

                            }
                    }
                  }
                else if(typeof(obj.warning) != 'undefined'){
                        $('.systemMessage').html("<div class='warning'>"+obj.warning+"</div>");
                    }
            }
        }
    }


    ajax.open('GET', object.target.href, true);
    ajax.onreadystatechange =processResponse;
    ajax.send(null);
    return false;
}

function addUser(e){

    e.preventDefault();
    e.stopPropagation();


    var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";

    if(location.hostname == "localhost"){
        url += "simpleMVC/"
    }

  var ajax = ajaxOpen();
  var object = url+"index.php?url=user/create";
    function processResponse()
    {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var obj = eval('(' + ajax.responseText + ')');
                $('.systemMessage').html("<div class='message'>"+obj.messages+"</div>");
                $('.message').delay(2000).slideUp('slow');

                var table = document.getElementById("users");
                var lenght = table.rows.length;

                var row = table.insertRow(lenght);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);

                cell1.innerHTML = obj.usrLogin;
                cell2.innerHTML = obj.usrEmail;
                cell3.innerHTML = obj.usrName;
                cell4.innerHTML = obj.usrSurname;
                cell5.innerHTML = "<a href='"+url+"index.php?url=user/edit&us_id="+obj.usrId+"'>Edytuj</a>";
                cell6.innerHTML = "<a class='remove-user' href='"+url+"index.php?url=user/remove&us_id="+obj.usrId+"'>Usuń</a>";

                users();
            }
        }
    }

    ajax.onreadystatechange =processResponse;

    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var email = document.getElementById('email').value;
    var login = document.getElementById('login').value;
    var password = document.getElementById('password').value;
    var params = "name="+name+"&surname="+surname+"&email="+email+"&login="+login+"&password="+password;
    ajax.open("POST", object, true);

    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    ajax.send(params);
}

function saveConfig(e){

    e.preventDefault();
    e.stopPropagation();


    var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";

    if(location.hostname == "localhost"){
        url += "simpleMVC/"
    }

    var object = url +"admin/index.php?url=admin/configurationsave";

    var ajax = ajaxOpen();

    function processResponse()
    {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var obj = eval('(' + ajax.responseText + ')');
                $('.systemMessage').html("<div class='message'>"+obj.messages+"</div>");
                $('.message').delay(2000).slideUp('slow').delay(3000, function(){
                    location.reload();
                });
            }
        }
    }

    ajax.onreadystatechange =processResponse;

    var date = document.getElementById('date').value;
    var zone = document.getElementById('zone').value;
    var time = document.getElementById('time').value;
    var template = document.getElementById('template').value;
    var params = "date="+date+"&zone="+zone.replace("+",encodeURIComponent('+'))+"&time="+time+"&template="+template;

    ajax.open("POST", object, true);

    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    ajax.send(params);
}

function addCategory(e){
    e.preventDefault();
    e.stopPropagation();

    var url = location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";

    if(location.hostname == "localhost"){
        url += "simpleMVC/"
     }

    var ajax = ajaxOpen();
    var object = url+"index.php?url=category/add";


    function processResponse()
    {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {

                var obj = eval('(' + ajax.responseText + ')');
                $('.systemMessage').html("<div class='message'>"+obj.messages+"</div>");
                $('.message').delay(2000).slideUp('slow');

                var table = document.getElementById("categorys");
                var lenght = table.rows.length;

                var row = table.insertRow(lenght);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);

                cell1.innerHTML = obj.catName;
                cell2.innerHTML = obj.catDescription;
                cell3.innerHTML = "<a href='"+url+"index.php?url=category/edit&cat_id="+obj.catId+"'>Edytuj</a>";
                cell4.innerHTML = "<a class='remove-category' href='"+url+"index.php?url=category/remove&cat_id="+obj.catId+"'>Usuń</a>";

                categories();
            }
        }
    }

    ajax.onreadystatechange =processResponse;

    var name = document.getElementById('name').value;
    var description = document.getElementById('description').value;
    var params = "name="+name+"&description="+description;

    ajax.open("POST", object, true);

    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    ajax.send(params);
}

function removeCategory(object){

    object.preventDefault();
    object.stopPropagation();

    var ajax = ajaxOpen();

    function processResponse()
    {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var obj = eval('(' + ajax.responseText + ')');
                if(typeof(obj.messages) != 'undefined'){
                    $('.systemMessage').html("<div class='message'>"+obj.messages+"</div>");
                    $('.message').delay(2000).slideUp('slow');

                    var table = document.getElementById("categorys");
                    var lenght = table.rows.length;

                    for(var i =0 ; i < lenght; i++){
                        var rows = table.rows[i].cells.length;

                        for(var i2= 0; i2 < rows; i2++){
                            if(table.rows[i].cells[i2].innerHTML.replace(/\&amp;/g,'&').indexOf(object.target.href) != -1){
                                table.deleteRow(i);
                            }

                        }
                    }
                }
                else if(typeof(obj.warning) != 'undefined'){
                    $('.systemMessage').html("<div class='warning'>"+obj.warning+"</div>");
                }
            }
        }
    }


    ajax.open('GET', object.target.href, true);
    ajax.onreadystatechange =processResponse;
    ajax.send(null);
    return false;
}

function removeTopic(object){

    object.preventDefault();
    object.stopPropagation();

    var ajax = ajaxOpen();

    function processResponse()
    {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                var obj = eval('(' + ajax.responseText + ')');
                if(typeof(obj.messages) != 'undefined'){
                    $('.systemMessage').html("<div class='message'>"+obj.messages+"</div>");
                    $('.message').delay(2000).slideUp('slow');

                    var tables = document.getElementsByClassName("topics");
                  for(var i3 = 0 ; i3 < tables.length ; i3++ ){
                    var lenght = tables[i3].rows.length;
                    for(var i =0 ; i < lenght; i++){
                        var rows = tables[i3].rows[i].cells.length;
                        for(var i2= 0; i2 < rows; i2++){
                            if(tables[i3].rows[i].cells[i2].innerHTML.replace(/\&amp;/g,'&').indexOf(object.target.href) != -1){
                                tables[i3].deleteRow(i);
                            }

                        }
                    }
                  }
                }
                else if(typeof(obj.warning) != 'undefined'){
                    $('.systemMessage').html("<div class='warning'>"+obj.warning+"</div>");
                }
            }
        }
    }


    ajax.open('GET',object.target.href, true);
    ajax.onreadystatechange =processResponse;
    ajax.send(null);
    return false;
}

function ajaxOpen(){
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlhttp;
}

function users(){
    var users = document.getElementsByClassName('remove-user');
    for (i = 0; i < users.length; i++){
        users[i].addEventListener('click', removeUser, false);
    }
}

function categories(){

    var categories = document.getElementsByClassName('remove-category');
    for (i = 0; i < categories.length; i++){
        categories[i].addEventListener('click', removeCategory, false);
    }
}

function topics(){
    var topics = document.getElementsByClassName('remove-topic');
    for (i = 0; i < topics.length; i++){
        topics[i].addEventListener('click', removeTopic, false);
    }
}