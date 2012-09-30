<?php
/**
 * Class for models
 */

/**
 * Class implements all models functionality.
 * @package core
 * @subpackage model
 * @param string $table_name if its null we get name from Model name
 */
class Model extends ModelSQLManager
{
    /**
     * Name of database table.
     * @var null|string
     */
    protected $table_name = null;

    /**
     *Construct mapping Database variables to object.
     */
    function __construct()
    {
        if ($this->table_name == null) {
            $name = get_class($this);
            $this->table_name = strtolower(preg_replace("/Model/", "", $name));
        }

        try {
            parent::__construct();
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
    }

    /**
     *Close Database connection.
     */
    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Method get object from database by id key.
     * @param array $primaryKeys
     * @return mixed
     */
    public function getById($primaryKeys)
    {
        try {
            return parent::getById($primaryKeys);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return false;
    }

    /**
     * Method get object from database by $statement.
     * @param string $statement
     * @return mixed
     */
    public function getQueryObject($statement)
    {
        try {
            return parent::getQueryObject($statement);
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }

        return false;
    }

    /**
     * Method return all object of this model from database.
     * @return array|bool
     */
    public function getAll()
    {
        try {
            return parent::getAll();
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }

        return false;
    }

    /**
     * Method save object in database. If it new object, insert into database.
     * @return bool|string
     */
    public function save()
    {
        try {
            return parent::save();
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }

    /**
     * Method remove object from database by id.
     * @param array $primaryKeys
     * @return mixed|void
     */
    public function removeById($primaryKeys)
    {
        try {
            parent::removeById($primaryKeys);
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
    }

    /**
     * Function remove model if it's not new.
     */
    public function remove()
    {

        try {
            parent::remove();

        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
    }

    /**
     * Method return count of objects in database;
     * @return bool
     */
    public function count()
    {
        try {
            return parent::count();
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
    }


}
