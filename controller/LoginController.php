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
    protected function actionIndex()
    {
        if (Application::isGuest())
            parent::actionIndex();
        else
            $this->redirectToOther("", "");
    }

    protected function beforeRender()
    {
        $this->setTitle(" Zaloguj");

        if (isset($_POST['zaloguj'])) {
            unset($_POST['zaloguje']);
            $user = new UserModel();
            $user->login($_POST["login"], $_POST["password"]);
            if (!Application::isGuest()) {
                $this->redirectToOther("", "");
            } else {
                $_SESSION["error"] = array("type" => "error", "message" => "Niepoprawny login lub hasło");
            }
        }

    }


}
