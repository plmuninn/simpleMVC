<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 13.04.12
 * Time: 18:26
 *
 */

/*Main site controller*/
class SiteController extends Controller
{


    /**
     *Controller redirect to index.php on root site
     */
    function __construct()
    {
        parent::generateControllers();

       try{
           if(!isset($this->component)){
                if($this->controllers != null && $this->actions == null){
                    if(!parent::redirect()){
                        throw new Exception ("Site don't found.");
                    }
                }
                 else{
                     parent::actionIndex();
                 }
           }
           else
               parent::redirectComponent();

       }
       catch(Exception $e){
           echo $e->getMessage();
       }
    }

    function __destruct()
    {
        parent::__destruct();
    }

    protected function afterRender()
    {

    }

    protected function beforeRender()
    {
       parent::setTitle("");
    }


}
