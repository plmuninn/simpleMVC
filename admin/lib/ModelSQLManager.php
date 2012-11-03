<?php
/**
 * Class mapping database columns to PHP Object values
 */

/**
 *Class mapping database columns to PHP Object values and manage a relations
 *
 * @package core
 * @subpackage model
 *
 * @property string $table_name
 * @property array $primary
 * @property array $variablesTypes
 * @property bool $new
 */
class ModelSQLManager extends ApplicationDB implements SQLManagerInterface
{

    /**
     * A model table name.
     * @var null
     */
    protected $table_name = null;

    /**
     * Primary keys array.
     * @var array
     */
    protected $primary = array();

    /**
     * Variables type mapping values
     * @var array
     */
    protected $variablesTypes = array();

    /**
     * If object is new to create or save in DB.
     * @var bool
     */
    protected $new = true;

    /**
     * PluginManager
     * @var
     */
    protected $plugins;

    /**
     * Map database columns to PHP Object
     * @throws Exception
     */

    /**
     * Array with relations keys
     * @var Array
     */
    protected $relationsArray = array();

    /**
     * Constructor initialize model objects and references.
     */
    function __construct()
    {

        $this->plugins = new PluginManager();
        $config = new Configuration();
        switch ($config->getDBType()) {
            case "mysql":
                $this->mysql();
                break;
        }

    }

    /**
     * Get values from mysql database
     * @throws Exception
     */
    private function mysql()
    {

        /*Remove database relations*/
        //     $this->indexes();

        $db = $this->connectDB();
        if ($this->table_name != '') {
            $sql = "SHOW COLUMNS FROM " . $this->table_name;
            $stmt = $db->prepare($sql);
            $arr = array();
            try {
                if ($stmt->execute()) {
                    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                        array_push($arr, $obj);

                    }
                    for ($i = 0; $i < count($arr); $i++) {
                        if (strtolower($arr[$i]->Key) == "pri") {
                            $this->primary[strtolower($arr[$i]->Field)] = $arr[$i]->Extra;
                        }
                        $this->{strtolower($arr[$i]->Field)} = NULL;
                        $this->variablesTypes[strtolower($arr[$i]->Field)] = $arr[$i]->Type;
                    }
                }
            } catch (Exception $e) {
                $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
            }
        } else {
            throw new Exception("Don't find column name " . $this->table_name);
        }
    }

    /**
     * Get relations keys from information schema.
     * @throws Exception
     */
    private function indexes()
    {
        $db = $this->connectDB();
        if ($this->table_name != '') {
            $sql = "SELECT table_name, column_name,
                    referenced_table_name, referenced_column_name
                    FROM INFORMATION_SCHEMA.key_column_usage
                    WHERE referenced_table_schema = '" . DB_NAME . "'
                    AND referenced_table_name IS NOT NULL AND table_name = '$this->table_name'
                    ORDER BY table_name, column_name";
            $stmt = $db->prepare($sql);
            try {
                if ($stmt->execute()) {
                    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                        array_push($this->relationsArray, $obj);
                    }
                    if (count($this->relationsArray) > 0)
                        $this->generateModels();
                }
            } catch (Exception $e) {
                $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
            }
        } else {
            throw new Exception("Don't find column name " . $this->table_name);
        }
    }

    /**
     * Method create a referenced model objects.
     */
    private function generateModels()
    {
        foreach ($this->relationsArray as $relation) {
            $model = ucfirst(strtolower($relation->referenced_table_name)) . "Model";
            $instance = new $model();
            $modelName = lcfirst($model);
            $this->{$modelName} = $instance;
        }
    }

    /**
     * Close Database connection
     */
    function __destruct()
    {
        parent::__destruct();
    }


    /**
     * Return object from database by $primaryKeys
     * @param array $primaryKeys
     * @return mixed
     */
    public function getById($primaryKeys)
    {
        if (is_array($primaryKeys)) {
            $db = $this->connectDB();
            $sql = "SELECT * FROM " . $this->table_name . " WHERE ";
            $name = get_class($this);

            foreach ($primaryKeys as $key => $value) {
                $sql .= "`" . $key . "`= :" . $key . " AND ";
            }

            $sql = substr($sql, 0, -4);
            $stmt = $db->prepare($sql);

            foreach ($primaryKeys as $key => $value) {
                $stmt->bindParam(":" . $key, $value, ValueCheck::showPDOType(array($key => $value), $this->variablesTypes));
            }

            try {
                if ($stmt->execute()) {
                    $obj = $stmt->fetch(PDO::FETCH_OBJ);
                    $instance = new $name();
                    $instanceVars = $this->variablesTypes;

                    if (!is_bool($obj)) {
                        foreach ($instanceVars as $key => $value) {
                            $instance->{$key} = $obj->{$key};
                        }

                        /*Remove database relations*/
                        // $this->models($instance);
                    }
                    $instance->setNew(false);
                    return $instance;
                }
            } catch (Exception $e) {
                $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
            }
        }
        return false;
    }

    /**
     * Method return one object or array with objects from database by $statement
     * @param string $statement
     * @return mixed
     */
    public function getQueryObject($statement)
    {
        $db = $this->connectDB();
        $name = get_class($this);
        $stmt = $db->prepare($statement);
        $objects = array();

        try {
            if ($stmt->execute()) {
                while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {

                    $instance = new $name();
                    $instanceVars = $this->variablesTypes;

                    if (!is_bool($obj)) {
                        foreach ($instanceVars as $key => $value) {
                            $instance->{$key} = $obj->{$key};
                        }

                        /*Remove database relations*/
                        // $this->models($instance);
                        $instance->setNew(false);
                        array_push($objects, $instance);
                    }
                }
                if (count($objects) > 1) {
                    return $objects;
                } else if (count($objects) == 1) {
                    return $objects[0];
                } else if (count($objects) <= 0) {
                    return false;
                }
            }
        } catch (ErrorException $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }

    /**
     * Make query from $statement. If query return something, it return array else true or false.
     * @param $statement
     * @return mixed
     */
    public function query($statement)
    {
        $db = $this->connectDB();
        $stmt = $db->prepare($statement);
        $objects = array();

        try {
            if ($stmt->execute()) {
                while ($obj = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    array_push($objects, $obj);
                }
                if (count($objects) > 0)
                    return $objects;
                else
                    return true;
            } else {
                return false;
            }
        } catch (ErrorException $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }

    /**
     * Return array of all object's in database.
     * @return mixed
     */
    public function getAll()
    {
        $db = $this->connectDB();
        $sql = "SELECT * FROM " . $this->table_name;
        $stmt = $db->prepare($sql);
        $arr = array();
        $name = get_class($this);

        try {
            if ($stmt->execute()) {
                while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $instance = new $name();
                    $instanceVars = $this->variablesTypes;

                    foreach ($instanceVars as $key => $value) {
                        $instance->{$key} = $obj->{$key};
                    }

                    /*Remove database relations*/
                    // $this->models($instance);

                    $instance->setNew(false);
                    array_push($arr, $instance);
                }
                $stmt = null;

                return $arr;
            }
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }


    /**
     * Method save or update record with data i database.
     * @return mixed
     * @throws Exception
     */
    public function save()
    {
        $this->beforeSave($this);
        $db = $this->connectDB();

        /*Remove database relations*/
        //  $this->relationValues();

        if ($this->new) {
            $sql = "INSERT INTO " . $this->table_name . " (";
            $sql_values = " VALUES(";
            /*Check variables*/
            foreach ($this->variablesTypes as $key => $value) {
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                /*Remove AutoIncrements on ID*/
                $primKey = array_keys($this->getPrimary());
                if ($key != $primKey[0]) {
                    $sql .= "`" . $key . "` ,";
                    if (ValueCheck::isGoodType($valueArr, $this->variablesTypes)) {
                        $sql_values .= ":" . $key . ",";
                    } else {
                        throw new Exception("Bad type of variable " . $key);
                    }
                }
            }

            $sql_values = substr($sql_values, 0, -1);
            $sql_values .= ")";
            $sql = substr($sql, 0, -1);
            $sql .= ")";
            $sql .= $sql_values;
            $stmt = $db->prepare($sql);
            /*Bind params*/
            foreach ($this->variablesTypes as $key => $value) {
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                $primKey = array_keys($this->getPrimary());
                if ($key != $primKey[0]) {
                    $stmt->bindParam(":" . $key, $this->{$key}, ValueCheck::showPDOType(array($key => $this->{$key}), $this->variablesTypes));
                }
            }
            try {
                if ($stmt->execute()) {
                    $this->new = false;
                    $key = array_keys($this->getPrimary());
                    $this->{$key[0]} = $db->lastInsertId();
                    return $this->{$key[0]};
                }
            } catch (ErrorException $e) {
                $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
            }

        } else {
            $sql = "UPDATE " . $this->table_name . " SET ";
            foreach ($this->variablesTypes as $key => $value) {
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                $primKey = array_keys($this->getPrimary());
                if ($key != $primKey[0]) {
                    if (ValueCheck::isGoodType($valueArr, $this->variablesTypes)) {
                        $sql .= "`" . $key . "`= :" . $key . ",";
                    } else {
                        throw new Exception("Bad type of variable " . $key);
                    }
                }

            }

            $sql = substr($sql, 0, -1);
            $sql .= " WHERE ";
            foreach ($this->primary as $key => $value) {
                $sql .= "`" . $key . "`= :" . $key . " AND ";
            }
            $sql = substr($sql, 0, -4);
            $stmt = $db->prepare($sql);
            /*Bind params*/
            foreach ($this->variablesTypes as $key => $value) {
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                $primKey = array_keys($this->getPrimary());
                if ($key != $primKey[0]) {
                    $stmt->bindParam(":" . $key, $this->{$key}, ValueCheck::showPDOType(array($key => $this->{$key}), $this->variablesTypes));
                }
            }
            foreach ($this->primary as $key => $value) {
                $stmt->bindParam(":" . $key, $this->{$key}, ValueCheck::showPDOType(array($key => $this->{$key}), $this->variablesTypes));
            }

            try {
                return $stmt->execute();
            } catch (ErrorException $e) {
                $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
            }

        }
        $this->afterSave();
        return false;
    }

    /**
     * Generate from relations models values to model.
     */
    private function relationValues()
    {
        if (count($this->getRelationsArray()) > 0) {
            foreach ($this->getRelationsArray() as $relationObject) {
                $instance = $this->{lcfirst(strtolower($relationObject->referenced_table_name)) . "Model"};

                $key = array_keys($instance->getPrimary());

                $instance2 = $instance->getById(array($key[0] => $instance->{$key[0]}));
                if (!is_bool($instance2))
                    $instance = $instance2;

                if ($instance->getNew())
                    $instance->save();

                if (is_bool($instance2))
                    $instance = $instance->getById(array($key[0] => $instance->{$key[0]}));

                if (isset($instance->{$relationObject->referenced_column_name})) {
                    if (!isset($this->{$relationObject->column_name}))
                        $this->{$relationObject->column_name} = $instance->{$relationObject->referenced_column_name};
                }
            }
        }
    }

    /**
     * Method remove object from database by $primaryKeys
     * @param array $primaryKeys
     * @return mixed
     */
    public function removeById($primaryKeys)
    {
        $db = $this->connectDB();

        $sql = "DELETE FROM " . $this->table_name . " WHERE ";

        foreach ($primaryKeys as $key => $value) {
            $sql .= "`" . $key . "`= :" . $key . " AND ";
        }
        $sql = substr($sql, 0, -4);
        $stmt = $db->prepare($sql);
        foreach ($primaryKeys as $key => $value) {
            $stmt->bindParam(":" . $key, $value, ValueCheck::showPDOType(array($key => $value), $this->variablesTypes));
        }
        try {
            $deleted = $stmt->execute();
            if ($deleted) {
                $this->new = true;
            }
            return $deleted;
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }

    /**
     * Function remove model if it's not new.
     * @throws Exception
     */
    public function remove()
    {
        if (!$this->new) {
            $key = array_keys($this->getPrimary());
            $this->removeById(array($key[0] => $this->{$key[0]}));
        } else {
            throw new Exception("Model was new, cant remove.");
        }
    }


    /**
     * Return array with objects by $primaryKeys
     * @param array $primaryKeys
     * @return mixed
     */
    public function getAllById($primaryKeys)
    {
        $models = array();

        if (is_array($primaryKeys)) {
            $db = $this->connectDB();
            $sql = "SELECT * FROM " . $this->table_name . " WHERE ";
            $name = get_class($this);

            foreach ($primaryKeys as $key => $value) {
                $sql .= $key . "= :" . $key . " AND ";
            }

            $sql = substr($sql, 0, -4);
            $stmt = $db->prepare($sql);

            foreach ($primaryKeys as $key => $value) {
                $stmt->bindParam(":" . $key, $value, ValueCheck::showPDOType(array($key => $value), $this->variablesTypes));
            }
            try {
                if ($stmt->execute()) {
                    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $instance = new $name();
                        $instanceVars = $this->variablesTypes;

                        if (!is_bool($obj)) {
                            foreach ($instanceVars as $key => $value) {
                                $instance->{$key} = $obj->{$key};
                            }

                            /*Remove database relations*/
                            // $this->models($instance);
                        }
                        $instance->new = false;
                        array_push($models, $instance);
                    }
                }
                if (count($models) > 0) {
                    return $models;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
            }
        }
        return false;
    }

    /**
     * Method generate instance of models with values.
     * @param $instance
     */
    private function models(&$instance)
    {
        if (count($this->relationsArray) > 0) {
            foreach ($this->getRelationsArray() as $relationObject) {
                $modelInstance = $instance->{lcfirst(strtolower($relationObject->referenced_table_name)) . "Model"};
                $primarys = $modelInstance->getPrimary();
                $primarysKeys = array_keys($primarys);
                if (count($primarysKeys) > 0) {
                    if (property_exists($modelInstance, $primarysKeys[0])) {
                        $returned = $modelInstance->getById(array($primarysKeys[0] => $instance->{$relationObject->column_name}));
                        if (!is_bool($returned)) ;
                        $instance->{lcfirst(strtolower($relationObject->referenced_table_name)) . "Model"} = $returned;
                    }
                }
            }
        }
    }

    /**
     * Method return count of objects in database;
     * @return bool
     */
    public function count()
    {
        $db = $this->connectDB();
        $sql = "SELECT COUNT(*) as count FROM " . $this->table_name;
        $stmt = $db->prepare($sql);
        try {
            if ($stmt->execute()) {
                $obj = $stmt->fetch(PDO::FETCH_OBJ);
                return $obj->count;
            }
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }

    /**
     * Return next id in table.
     * @return mixed
     */
    public function getMaxId()
    {
        $db = $this->connectDB();
        $key = array_keys($this->getPrimary());
        $sql = "SELECT MAX(" . $key[0] . ") as id FROM " . $this->table_name;
        $stmt = $db->prepare($sql);
        try {
            if ($stmt->execute()) {
                $obj = $stmt->fetch(PDO::FETCH_OBJ);
                return $obj->id + 1;
            }
        } catch (Exception $e) {
            $_SESSION["error"] = array("type" => "error", "message" => $e->getMessage());
        }
        return false;
    }

    /**
     *We can do something with data after save.
     */
    protected function afterSave()
    {
        $this->plugins->afterSave();
    }

    /**
     * We can do something with data before save.
     * @param $model
     */
    protected function beforeSave(&$model)
    {
        $this->plugins->beforeSave($model);
    }

    /**
     * Return all variable types from database
     * @return array
     */
    public function getVariablesTypes()
    {
        return $this->variablesTypes;
    }

    /**
     * Array with relation keys
     * @return Array
     */

    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * Array with relations keys
     * @return Array
     */
    public function getRelationsArray()
    {
        return $this->relationsArray;
    }

    /**
     * If object is new in database or isn't.
     * @return bool
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     *  If object is new in database or isn't.
     * @param bool $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }

}
