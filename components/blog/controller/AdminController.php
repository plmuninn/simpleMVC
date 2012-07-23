<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.07.12
 * Time: 17:02
 *
 */
class AdminController extends Component
{

    public function __construct(){
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    public function addRender(){
        if(!Application::isGuest()){
            if(Application::isOwner(HTMLManager::cleanInput($_POST["id_user"]))){
             $id = HTMLManager::cleanInput($_POST["id_user"]);
             $short = HTMLManager::cleanInput($_POST["short"]);
             $long = HTMLManager::cleanInput($_POST["long"]);
             $blog = new BlogModel();

                if(isset($_POST["blog_id"])){
                $blog = $blog->getById(array("id_blog" => HTMLManager::cleanInput($_POST["blog_id"])));
                }

             $blog->short = $short;
             $blog->long = $long;
             $blog->id_user = $id;

                if($blog->save()){
                    $_SESSION["error"] = array("type"=>"message","message"=>"Dodano wpis");
                    $this->redirectToOtherComponent("blog/account&comp=blog&user_id=".Application::loggedUser()->id_user);
                }
                else{
                    $_SESSION["error"] = array("type"=>"error","message"=>"Błąd przy dodawaniu");
                    $this->redirectToOtherComponent("blog/account&comp=blog&user_id=".Application::loggedUser()->id_user);
                }
           }
            else{
                $_SESSION["error"] = array("type"=>"warning","message"=>"Nie włamujemy się ; )");
                $this->redirectToOther("",false);
            }
        }
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login",false);
        }

    }

    public function editRender(){
        if(!Application::isGuest()){
         $this->render("index");
        }
        else
            $this->redirectToOther("login",false);
    }

    public function removeRender(){

        if(isset($_GET["blog_id"]) && !empty($_GET["blog_id"])){
           $blog = new BlogModel();
           $blog->removeById(array("id_blog" => HTMLManager::cleanInput($_GET["blog_id"])));
           $_SESSION["error"] = array("type"=>"message","message"=>"Usunięto wpis");
           $this->redirectToOtherComponent("blog/account&comp=blog&user_id=".Application::loggedUser()->id_user);
        }
        else
          $this->redirectToOtherComponent("admin");
    }
}
