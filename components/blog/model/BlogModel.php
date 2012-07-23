<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 23.07.12
 * Time: 17:27
 *
 */
class BlogModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    protected function afterSave()
    {
        parent::afterSave();
    }

    protected function beforeSave()
    {
        parent::beforeSave();
    }

    public function getUser($id){
        return $this->getAllById(array("id_user" => $id));
    }

    public function getUserLast($id){
       $userAll =  $this->getUser($id);
       $lenght = count($userAll);
        return $userAll[$lenght-1];
    }
}
