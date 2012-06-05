<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.04.12
 * Time: 10:56
 *
 */
class UserModel extends TemplateMod
{


    /**
     *Model constructor
     */
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


    /**Method login user
     * @param $login
     * @param $password
     */
    public function login($login,$password){
      $usr =  $this->getById(array("login"=>$login));
            if(  $usr->password == md5($password)){
              Application::sendSessionModel( $usr);
            }
    }
}
