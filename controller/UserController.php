<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 10:58
 *
 *
 */
class UserController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    protected function renderIndex()
    {
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else {
            $usr = $_SESSION["user"];
            $this->redirectToOther("user/account&us_id=$usr->id_user", false);}
        parent::renderIndex();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    protected function afterRender()
    {
        parent::afterRender();
    }

    protected function beforeRender()
    {
        parent::beforeRender();
    }

    public function createRender(){

        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else  if(Application::isAdmin()){

            $this->model->name = HTMLManager::cleanInput($_POST["name"]);
            $this->model->surname = HTMLManager::cleanInput($_POST["surname"]);
            $this->model->login = HTMLManager::cleanInput($_POST["login"]);
            $this->model->email = HTMLManager::cleanInput($_POST["email"]);
            $this->model->password = md5($_POST["password"]);
            $id = $this->model->save();

            echo  json_encode(array('messages'=>"Użytkownik dodany", 'usrName' =>$this->model->name, 'usrSurname'=>$this->model->surname, 'usrLogin'=>$this->model->login,'usrEmail'=>$this->model->email , 'usrId' => $id));
        }
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->renderIndex();
        };
    }

    public function removeRender(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else  if(Application::isAdmin()){
            $this->model->removeById(array("id_user" => HTMLManager::cleanInput($_GET["us_id"])));
            $usr = $this->model->getById(array("id_user" => HTMLManager::cleanInput($_GET["us_id"])));

            if($usr->id_user != null){
                echo  json_encode(array('warning'=>"Nie udało się usunąć, skontakuj się ze samym sobą!(czyt. z Maciejem Romańskim)"));
            }
            else{
                echo  json_encode(array('messages'=>"Użytkownik usunięty"));
            }
            }
        else{
           $_SESSION["error"]  = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->renderIndex();

        };
    }

    public function editRender(){
        $_SESSION["title"] = "- Edycja użytkownika";

        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else  if(Application::isAdmin()){
            if(isset($_POST['user-edit'])){
                unset($_POST['user-edit']);
                $user = $this->model->getById(array("id_user" => HTMLManager::cleanInput($_GET["us_id"])));
                $user->name = HTMLManager::cleanInput($_POST["name"]);
                $user->surname = HTMLManager::cleanInput($_POST["surname"]);
                $user->login = HTMLManager::cleanInput($_POST["login"]);
                $user->email = HTMLManager::cleanInput($_POST["email"]);
              if($_POST["password"] != ''){
                  $user->password = md5($_POST["password"]);
                  $user->save();
              }
                $user->save();
                $_SESSION["error"] = array("type"=>"message","message"=>"Użytkownik zapisany");
                $this->redirectToOther("admin/user",true);
            }
        $this->render("edit");
        }
        else{
            $_SESSION['error'] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->renderIndex();

        };
    }

    public function listRender(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else  if(Application::isAdmin())
            $this->render("list");
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->renderIndex();
        }
    }

    public function registrationRender(){
        if(Application::isGuest())
            if(isset($_POST["submit"])){
             $user = new UserModel();
                $user->name = HTMLManager::cleanInput($_POST["name"]);
                $user->surname = HTMLManager::cleanInput($_POST["surname"]);
                $user->login = HTMLManager::cleanInput($_POST["login"]);
                $user->email = HTMLManager::cleanInput($_POST["email"]);
                if($_POST["password"] == $_POST["password_repeat"]){
                    $user->password = md5($_POST["password"]);
                    $user->save();
                    $this->redirectToOther("login", false);
                }
                else{
                    $_SESSION["error"] = array("type"=>"warning","message"=>"Nie poprawne hasła");
                    $this->renderIndex();
                };

            }
            else
            $this->render("registration");
        else
            $this->redirectToOther("user/account", false);
    }

    public function viewRender(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else  if(Application::isAdmin())
        $this->render("view");
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->renderIndex();
        }
    }

    public function logoutRender(){
       $usr = $_SESSION["user"];
       Application::removeSessionModel($usr);
       $this->redirectToOther("", false);
    }

    public function saveRender(){

    }

    public function accountRender(){
        $_SESSION["title"] = "- Panel użytkownika";
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", false);}
        else{
            if($_SESSION["user"]->id_user == $_GET['us_id']){
                if(isset($_POST["us_id"])){
            if($_SESSION["user"]->id_user == $_POST["us_id"]){
                if(isset($_POST["user-save"])){
                    unset($_POST["user-save"]);
                  $user = $this->model->getById(array("id_user" => HTMLManager::cleanInput($_POST["us_id"])));
                    $user->name = HTMLManager::cleanInput($_POST["name"]);
                    $user->surname = HTMLManager::cleanInput($_POST["surname"]);
                    $user->login =  HTMLManager::cleanInput($_POST["login"]);
                    $user->email = HTMLManager::cleanInput($_POST["email"]);
                    $user->save();
                    $_SESSION["error"] = array("type"=>"message","message"=>"Dane zapisane");
            }}
            else if($_POST["password-save"]){
                unset($_POST["password-save"]);
                if($_POST["password"] == $_POST["password_repeat"]){
                    $user = $this->model->getById(array("id_user" => HTMLManager::cleanInput($_POST["us_id"])));
                    $user->password = md5($_POST["password"]);
                    $user->save();
                    $_SESSION["error"] = array("type"=>"message","message"=>"Hasło zmienione");
                }
                else{
                    $_SESSION["error"] = array("type"=>"warning","message"=>"Nie poprawnie powtórzone hasło");
                    $this->renderIndex();
                }
            }



            }
            else{
                $this->render("account");
            }
            }
            else{
                $_SESSION["error"] = array("type"=>"warning","message"=>"Ładnie to się tak włamywać?");
                $this->redirectToOther("",false);
            }
        }
        $this->render("account");
    }
}
