<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.07.12
 * Time: 08:46
 *
 */
class Shoutbox extends Module
{
        public $model = null;

       public function __construct(){
           parent::_construct();
           $this->initialization();
       }

        private function initialization(){
             $this->model = new ShoutboxModel();
             $this->render();
        }
}
