<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:40
 *
 */
class CategoryController  extends Controller
{
    function __construct()
    {
        parent::__construct();
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

    public function addAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else  if(Application::isAdmin()){
              $this->model->name = HTMLManager::cleanInput($_POST["name"]);
              $this->model->description = HTMLManager::cleanInput($_POST["description"]);
              $id = $this->model->save();

            echo  json_encode(array('messages'=>"Katgoria dodana", 'catName' =>$_POST["name"], 'catDescription'=>$_POST["description"],'catId' => $id));

        }
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->actionIndex();
        }
    }

    public function editAction(){
        $_SESSION["title"] = "- Edycja kategorii";

        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else  if(Application::isAdmin()){
              if(isset($_POST['cat-edit'])){
                  $category = $this->model->getById(array("id_category"=>HTMLManager::cleanInput($_GET["cat_id"])));
                  $category->name = HTMLManager::cleanInput($_POST["name"]);
                  $category->description = HTMLManager::cleanInput($_POST["description"]);
                  $category->save();
                  $_SESSION["error"] = array("type"=>"message","message"=>"Kategoria zapisana");
                  $this->redirectToOther("admin","kategorie",true);
              }
        $this->render("edit");}
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->actionIndex();}
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

    public function topicsAction(){
        $_SESSION["title"] = "- Tematy";
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else{
            Application::makeActualLink();
            $this->render("topics");
        }
    }

    public function removeAction(){
        if(Application::isGuest()){
            $_SESSION["error"] = array("type"=>"error","message"=>"Musisz być zalogowany");
            $this->redirectToOther("login", "");}
        else  if(Application::isAdmin()){
            $this->model->removeById(array("id_category" => HTMLManager::cleanInput($_GET["cat_id"])));
            $topics = $this->model->query("SELECT id_topic FROM topic WHERE category_id_category =".HTMLManager::cleanInput($_GET["cat_id"]));

            /*Usuwanie zależności*/
            $post = new PostModel();
            $topic = new TopicModel();
            if(is_array($topics)){
                foreach($topics as $key => $value){
                     $post->removeById(array("topic_id_topic"=>$value["id_topic"]));
                     $topic->removeById(array("id_topic"=>$value["id_topic"]));
                }
            }

            $cat = $this->model->getById(array("id_category"=>HTMLManager::cleanInput($_GET["cat_id"])));

            if($cat->id_category != null){
                echo  json_encode(array('warning'=>"Nie udało się usunąć, skontakuj się ze samym sobą!(czyt. z Maciejem Romańskim)"));
            }
            else{
                echo  json_encode(array('messages'=>"Kategorię usunięty"));
            }
        }
        else{
            $_SESSION["error"] = array("type"=>"error","message"=>"Nie jesteś administratorem");
            $this->actionIndex();}
    }


}
