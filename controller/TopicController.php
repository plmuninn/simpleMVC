<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:48
 *
 */
class TopicController  extends Controller
{
    public function addAction(){
        $_SESSION["title"] = "- Dodaj temat";

        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else  {
            if(isset($_POST['add-topic'])){
                unset($_POST['add-topic']);
                $_SESSION["error"] = array("type"=>"message","message"=>"Temat dodana");

                $title = HTMLManager::cleanInput($_POST['name']);
                $catid = HTMLManager::cleanInput($_POST['cat_id']);
                $usrid = HTMLManager::cleanInput($_POST['usr_id']);
                $added_date = HTMLManager::cleanInput($_POST['added_date']);
                $added_time = HTMLManager::cleanInput($_POST['added_time']);

                $this->model->title = $title;
                $this->model->category_id_category= $catid;
                $this->model->user_id_user = $usrid;
                $this->model->added_date = $added_date;
                $this->model->added_time = $added_time;
                $this->model->first_topic = '1';

                $id = $this->model->save();

                $post = new PostModel();

                $post->userModel->id_user = $usrid;
                $post->value = HTMLManager::cleanInput($_POST['value']);;
                $post->topic_id_topic = $id;
                $post->added_date = $added_date;
                $post->added_time = $added_time;

                $first_id = $post->save();

                $topic = new TopicModel();
                $topic = $topic->getById(array("id_topic"=>$id));

                $topic->first_topic = (int) $first_id;
                $topic->save();

                 $this->redirect("topic/posts&id_topic=".$id,false);
            }
            $this->render("add");
        }
    }

    public function editAction(){
        $_SESSION["title"] = "- Edycja tematu";

        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else {
                   if(isset($_POST["topic-edit"])){
                       unset($_POST["topic-edit"]);
                    $_SESSION["error"] = array("type"=>"message","message"=>"Zmiany zapisane");

                    $title = HTMLManager::cleanInput($_POST["name"]);
                    $cat = HTMLManager::cleanInput($_POST["category"]);
                    $id =  HTMLManager::cleanInput($_POST["topic_id"]);
                    $topic = $this->model->getById(array("id_topic" => $id));


                    if(Application::isOwner($topic->user_id_user) || Application::isAdmin()){
                    $topic->category_id_category = $cat;
                    $topic->title = $title;
                    $topic->save();

                    $first_post = new PostModel();
                    $first_post = $first_post->getById(array("id_post"=>$topic->first_topic));
                    $first_post->value = HTMLManager::cleanInput($_POST["value"]);
                    $first_post->save();

                    if(!strpos(Application::getActualLink(),"admin"))
                        $this->redirectToOther("category&cat_id=".$cat,"topics");
                    else
                        $this->redirectToOther("admin","tematy",true);
                }
                else{
                    $_SESSION["error"] = array("type"=>"error","message"=>"Brak dostępu");
                    $this->redirectToOther("", "");
                }
                   }
            $this->render("edit");}
    }

    public function listAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else  if(Application::isAdmin()){
            $this->render("list");}
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->actionIndex();}
    }

    public function removeAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else  {
            $topic = $this->model->getById(array("id_topic"=>HTMLManager::cleanInput($_GET["topic_id"])));
            if(Application::isOwner($topic->user_id_user) || Application::isAdmin()){
            $post = new PostModel();
            $post->removeById(array("topic_id_topic"=>HTMLManager::cleanInput($_GET["topic_id"])));
            $this->model->removeById(array("id_topic"=>HTMLManager::cleanInput($_GET["topic_id"])));

            $test = $this->model->getById(array("id_topic"=>HTMLManager::cleanInput($_GET["topic_id"])));


                if(strpos(Application::getActualLink(),"admin")){
            if(is_bool($test)){
                echo  json_encode(array('warning'=>"Nie udało się usunąć, skontakuj się ze samym sobą!(czyt. z Maciejem Romańskim)"));
            }
            else{
                echo  json_encode(array('messages'=>"Kategorię usunięty"));
            }}
            else{
                if(is_bool($test)){
                    $_SESSION["error"] = array("type"=>"error",'message'=>"Nie udało się usunąć, skontakuj się ze samym sobą!(czyt. z Maciejem Romańskim)");
                    $this->redirectToOther("","");
                }
                else{
                    $_SESSION["error"] = array("type"=>"message",'message'=>"Temat usunięty");
                    $this->redirectToOther("","");
                }
            }
        }
            else{
                $_SESSION["error"] = array("type"=>"error","message"=>"Brak dostępu");
                $this->redirectToOther("", "");
            }
        }
    }

    public function postsAction(){
        $_SESSION["title"] = "- Wiadomości";

        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else{
            Application::makeActualLink();
            $this->render("posts");
        }
    }

}
