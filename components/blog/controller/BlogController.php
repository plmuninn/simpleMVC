<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.07.12
 * Time: 17:01
 *
 */
class BlogController extends Component
{
    public function __construct(){
    parent::__construct();
    }

    public function __destruct(){
    parent::__destruct();
    }

    public function accountRender(){
        if(isset($_GET["user_id"]) && !empty($_GET["user_id"])){
        $this->render("account");
        }
        else
            $this->redirectToOther("",false);
    }

    public function topicRender(){
        if(isset($_GET["blog_id"]) && !empty($_GET["blog_id"])){
            $this->render("topic");
        }
        else
            $this->redirectToOther("",false);
    }

}