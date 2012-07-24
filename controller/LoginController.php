<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 21.04.12
 * Time: 10:20
 *
 */
class LoginController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    protected function actionIndex()
    {
        if(Application::isGuest())
        parent::actionIndex();
        else
        $this->redirectToOther("","");
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
        $this->setTitle(" Zaloguj");

        if(isset($_POST['zaloguj'])){
        unset($_POST['zaloguje']);
        $user = new UserModel();
        $user->login($_POST["login"],$_POST["password"]);
            if(!Application::isGuest()){
            $this->redirectToOther("", "");
        }
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Niepoprawny login lub hasło");
        }
    }

    }


}
