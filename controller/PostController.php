<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:48
 *
 */
class PostController extends Controller
{
    public function addAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else{
            if(isset($_POST["add-post"])){
               $this->model->value = HTMLManager::cleanInput($_POST["value"]);
               $this->model->topic_id_topic = HTMLManager::cleanInput($_POST["id_topic"]);
               $this->model->user_id_user = $_SESSION["user"]->id_user;
               $this->model->added_date = HTMLManager::cleanInput($_POST["added_date"]);
               $this->model->added_time = HTMLManager::cleanInput($_POST["added_time"]);


                if($this->model->save() != null)
               $_SESSION["error"] = array("type"=>"message","message"=>"Wiadomość dodana");
              else
                  $_SESSION["error"] = array("type"=>"error","message"=>"Wystąpił błąd");
                $this->redirectToOther("topic&id_topic=".HTMLManager::cleanInput($_POST["id_topic"]),"posts");
            }
            else
            $this->render("add");}
    }

    public function editAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else {
            if(isset($_POST["save-post"])){
                unset($_POST["save-post"]);
            $post = new PostModel();
                $id =  HTMLManager::cleanInput($_POST['id_post']);
            $post = $post->getById(array('id_post' => $id));
                if(Application::isOwner($post->user_id_user)||Application::isAdmin()){
            $post->value = HTMLManager::cleanInput($_POST["value"]);
            $post->save();
            $_SESSION["error"] = array("type"=>"message","message"=>"Wiadomość zapisana");
            $this->redirectToOther("topic&id_topic=".$post->topic_id_topic,"posts");
            }
                else{
                    $_SESSION["error"] = array("type"=>"error","message"=>"Brak dostępu");
                    $this->redirectToOther("", "");
                }
            }
            else
            $this->render("edit");}
    }

    public function removeAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else {
            $post = new PostModel();
            $id =  HTMLManager::cleanInput($_GET['post_id']);
            $post = $post->getById(array('id_post' => $id));
            if(Application::isOwner($post->user_id_user) || Application::isAdmin()){
            $this->model->removeById(array('id_post' => $id));

            $topic = new TopicModel();
            $topic = $topic->getById(array("id_topic"=>$post->topic_id_topic));

            if($topic->first_topic == $id){
            $topic = $topic->removeById(array("id_topic"=>$post->topic_id_topic));
                $this->model->removeById(array("topic_id_topic"=>$post->topic_id_topic));
                $_SESSION["error"] = array("type"=>"message","message"=>"Temat usunięty");
                $this->redirectToOther("","");
            }

            $_SESSION["error"] = array("type"=>"message","message"=>"Wiadomość usunięta");
            $this->redirectToOther("topic&id_topic=".$post->topic_id_topic,"posts");
        }
            else{
                $_SESSION["error"] = array("type"=>"error","message"=>"Brak dostępu");
                $this->redirectToOther("", "");
            }
        }
    }


}
