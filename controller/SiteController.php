<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 13.04.12
 * Time: 18:26
 *
 */

/*Main site controller*/
class SiteController extends TemplateControll
{


    /**
     *Controller redirect to index.php on root site
     */
    function __construct()
    {
        parent::generateControllers();

       try{
        if(count($this->controllers) != 0 && $this->controllers[0] != "index"){
            if(!parent::redirect()){
                echo "Site don't found.";
            }}
         else{
             parent::renderIndex();
         }}
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
