<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 24.04.12
 * Time: 22:44
 *
 */
class AdminController extends AdminManager
{

    /**
     *Constructor login user
     */
    function __construct()
    {
          parent::__construct();
        if (isset($_POST["login"]) && isset($_POST["password"])) {
            $_POST["password"] = md5($_POST["password"]);
            $usr = new UserModel();
            $usr = $usr->getQueryObject("SELECT * FROM user WHERE login =" . HTMLManager::cleanInput($_POST["login"]));
            if ($usr->password == $_POST["password"]) {
                unset($_POST["password"]);
                unset($_POST["login"]);
                Application::sendSessionModel($usr);
            }
        }

        if (Application::isGuest()) {
            $this->actionIndex();
        } else {
            if (Application::isAdmin()) {
                $this->panelAction();
            }
        }
    }

    /**
     *Render Administration panel
     */
    public function panelAction()
    {
        parent::generateModels();
        parent::generateControllers();

        if (sizeof($this->controllers) <= 0) {
            $_SESSION["title"] = "- AdminC";
            $this->render("panel");
        }
    }


    public function configAction()
    {
        $_SESSION["title"] = "- AdminC - Konfiguracje";
        $this->render("config");
    }

    public function userAction()
    {
        $_SESSION["title"] = "- AdminC - Użytkownicy";
        $this->render("user");
    }

    public function tematyAction()
    {
        $_SESSION["title"] = "- AdminC - Tematy";
        Application::makeActualLink();
        $this->render("tematy");
    }

    public function wiadomosciAction()
    {
        $_SESSION["title"] = "- AdminC - Wiadomości";
        $this->render("wiadomosci");
    }

    public function kategorieAction()
    {
        $_SESSION["title"] = "- AdminC - Kategorie";
        $this->render("kategorie");
    }

    public function configurationsaveAction()
    {
        $conf = new Configuration();
        $conf->setDateFormat($_POST["date"]);
        $conf->setTimeZone($_POST["zone"]);
        $conf->setTimeFormat($_POST["time"]);
        $conf->setTemplate($_POST["template"]);
        $conf->save();

        echo  json_encode(array('messages' => "Zapisano ustawienia"));
    }

}
