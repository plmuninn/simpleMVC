<?php

class UserModel extends Model
{

    /**Method login user
     * @param $login
     * @param $password
     */
    public function login($login, $password)
    {
        $usr = $this->getById(array("login" => $login));
        if ($usr->password == md5($password)) {
            Application::sendSessionModel($usr);
        }
    }
}
