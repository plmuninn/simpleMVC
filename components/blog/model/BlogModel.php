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
    public function getUser($id)
    {
        return $this->getAllById(array("id_user" => $id));
    }

    public function getUserLast($id)
    {
        $userAll = $this->getUser($id);
        $lenght = count($userAll);
        return $userAll[$lenght - 1];
    }
}
