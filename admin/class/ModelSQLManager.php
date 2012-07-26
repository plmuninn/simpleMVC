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
 *@property string $table_name
 *@property array $primary
 *@property array $variablesTypes
 *@property bool $new
 */
class ModelSQLManager  extends ApplicationDB implements SQLManagerInterface
{

    /**
     * A model table name.
     * @var null
     */
    protected  $table_name = null;

    /**
     * Primary keys array.
     * @var array
     */
    protected  $primary = array();

    /**
     * Variables type mapping values
     * @var array
     */
    protected  $variablesTypes = array();

    /**
     * If object is new to create or save in DB.
     * @var bool
     */
    protected  $new = true;

    /**
     * PluginManager
     * @var
     */
    protected $plugins;

    /**
     * Map database columns to PHP Object
     * @throws Exception
     */
    function __construct()
    {

        $this->plugins = new PluginManager();
        switch(DB_TYPE){
            case "mysql":
                $this->mysql();
            break;
        }

    }

    /**
     * Method returns relation keys.
     */
    private function getKeys(){
        //TODO: Keys sercher
    }

    /**
     * Method create relations
     */
    private function relations(){
        //TODO: Relation manager
    }

    /**
     * Get values from mysql database
     * @throws Exception
     */
    private function mysql()
    {
        $db = $this->connectDB();
        if($this->table_name != ''){
            $sql = "SHOW COLUMNS FROM ".$this->table_name;
            $stmt = $db->prepare($sql);
            $arr = array();
            try{
                if($stmt->execute()){
                    while($obj = $stmt->fetch(PDO::FETCH_OBJ)){
                        array_push($arr, $obj);
                    }
                        for($i = 0 ; $i < count($arr) ; $i++){
                                if(strtolower($arr[$i]->Key) == "pri"){
                                    $this->primary[strtolower($arr[$i]->Field)] = $arr[$i]->Extra;
                                }
                                    $this->{strtolower($arr[$i]->Field)} = NULL;
                                    $this->variablesTypes[strtolower($arr[$i]->Field)] = $arr[$i]->Type;
                        }
                }
            }
            catch(Exception $e){
                $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
            }
        }
        else{
            throw new Exception("Don't find column name ".$this->table_name);
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
     if(is_array($primaryKeys)){
        $db = $this->connectDB();
        $sql = "SELECT * FROM ".$this->table_name." WHERE ";
        $name = get_class($this);

         foreach($primaryKeys as $key => $value){
            $sql .="`".$key."`= :".$key." AND ";
        }

        $sql = substr($sql , 0 , -4);
        $stmt = $db->prepare($sql);

        foreach($primaryKeys as $key => $value){
           $stmt->bindParam(":".$key , $value,ValueCheck::showPDOType(array($key => $value), $this->variablesTypes));
        }

        try{
             if($stmt->execute()){
                 $obj = $stmt->fetch(PDO::FETCH_OBJ);
                     $instance = new $name();
                     $instanceVars = $this->variablesTypes;

                    if(!is_bool($obj)){
                         foreach($instanceVars as $key => $value){
                             $instance->{$key} = $obj->{$key};
                         }
                    }
                 $instance->new = false;
                 return $instance;
            }
        }
        catch(Exception $e){
            $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
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

        try{
            if($stmt->execute()){
                    while($obj = $stmt->fetch(PDO::FETCH_OBJ)){

                        $instance = new $name();
                        $instanceVars = $this->variablesTypes;

                        if(!is_bool($obj)){
                            foreach($instanceVars as $key => $value){
                                $instance->{$key} = $obj->{$key};
                            }
                           array_push($objects, $instance);
                        }
                    }
                        if(count($objects) > 1){
                           return $objects;
                        }else if (count($objects) == 1){
                           return $objects[0];
                        }
                        else if (count($objects) <= 0){
                           return false;
                        }
            }
        }
        catch(ErrorException $e){
            $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
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

        try{
            if($stmt->execute()){
               while($obj = $stmt->fetch(PDO::FETCH_ASSOC)){
                    array_push($objects,$obj);
                }
                 if(count($objects) > 0)
                    return $objects;
                     else
                       return true;
            }
            else{
                return false;
            }
        }
        catch(ErrorException $e){
            $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
        }
        return false;
    }

    /**
     * Return array of all object's in database.
     * @return mixed
     */
    public function getAll(){
        $db = $this->connectDB();
        $sql = "SELECT * FROM ".$this->table_name;
        $stmt = $db->prepare($sql);
        $arr = array();
        $name = get_class($this);

     try{
         if($stmt->execute()){
             while($obj = $stmt->fetch(PDO::FETCH_OBJ)){
                 $instance = new $name();
                    $instanceVars = $this->variablesTypes;

                 foreach($instanceVars as $key => $value){
                     $instance->{$key} = $obj->{$key};
                 }
              array_push($arr, $instance);
             }
             $stmt = null;

             return $arr;
         }
        }
        catch(Exception $e){
            $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
        }
        return false;
    }



    /**
     * Method save or update record with data i database.
     * @return mixed
     * @throws Exception
     */
    public function save(){
        $this->beforeSave($this);
        $db = $this->connectDB();
        if($this->new){
            $sql ="INSERT INTO ".$this->table_name." (";
            $sql_values = " VALUES(";
            /*Check variables*/
            foreach($this->variablesTypes as $key =>$value){
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                /*Remove AutoIncrements on ID*/
                if(!isset($this->primary[$key])){
                        $sql.="`".$key."` ,";
                        if(ValueCheck::isGoodType($valueArr, $this->variablesTypes)){
                            $sql_values .=":".$key.",";
                         }
                        else{
                            throw new Exception("Bad type of variable ".$key);
                        }
                }
            }

            $sql_values = substr($sql_values , 0 ,-1);
            $sql_values .=")";
            $sql = substr($sql , 0 ,-1);
            $sql .=")";
            $sql .= $sql_values;
            $stmt = $db->prepare($sql);
            /*Bind params*/
            foreach($this->variablesTypes as $key =>$value){
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                   /*Remove AutoIncrements on ID*/
                    if(!isset($this->primary[$key])){
                     $stmt->bindParam(":".$key ,$this->{$key},ValueCheck::showPDOType(array($key => $this->{$key}), $this->variablesTypes));
                    }
            }
            try{
                  if($stmt->execute()){
                    $this->new = false;
                    return $db->lastInsertId();
                  }
            }
            catch(ErrorException $e){
                $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
            }

        }
        else{
          $sql = "UPDATE ".$this->table_name." SET ";
            foreach($this->variablesTypes as $key =>$value){
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                /*Remove AutoIncrements on ID*/
                if(!isset($this->primary[$key])){
                    if(ValueCheck::isGoodType($valueArr, $this->variablesTypes)){
                        $sql .="`".$key."`= :".$key.",";
                    }
                    else{
                        throw new Exception("Bad type of variable ".$key);
                    }
                }

            }

            $sql = substr($sql , 0 ,-1);
            $sql .=" WHERE ";
            foreach($this->primary as $key => $value){
                $sql .="`".$key."`= :".$key." AND ";
            }
            $sql = substr($sql , 0 , -4);
            $stmt=$db->prepare($sql);
            /*Bind params*/
            foreach($this->variablesTypes as $key =>$value){
                $valueArr = array();
                $valueArr[$key] = $this->{$key};
                /*Remove AutoIncrements on ID*/
                if(!isset($this->primary[$key])){
                    $stmt->bindParam(":".$key ,$this->{$key},ValueCheck::showPDOType(array($key => $this->{$key}), $this->variablesTypes));
                }
            }
                foreach($this->primary as $key => $value){
                    $stmt->bindParam(":".$key ,$this->{$key},ValueCheck::showPDOType(array($key => $this->{$key}), $this->variablesTypes));
                }

            try{
                return $stmt->execute();
            }
            catch(ErrorException $e){
                $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
            }

        }
        $this->afterSave();
        return false;
    }


    /**
     * Method remove object from database by $primaryKeys
     * @param array $primaryKeys
     * @return mixed
     */
    public function removeById($primaryKeys){
        $db = $this->connectDB();
        $sql = "DELETE FROM ".$this->table_name." WHERE ";

        foreach($primaryKeys as $key => $value){
            $sql .="`".$key."`= :".$key." AND ";
        }
        $sql = substr($sql , 0 , -4);
        $stmt = $db->prepare($sql);
        foreach($primaryKeys as $key => $value){
            $stmt->bindParam(":".$key , $value,ValueCheck::showPDOType(array($key => $value), $this->variablesTypes));
        }
        try{
            $deleted = $stmt->execute();
            if($deleted){
               $this->new = true;
            }
            return $deleted;
        }
        catch(Exception $e){
            $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
        }
        return false;
    }


    /**
     * Return array with objects by $primaryKeys
     * @param array $primaryKeys
     * @return mixed
     */
    public function getAllById($primaryKeys)
    {
        $models = array();

        if(is_array($primaryKeys)){
            $db = $this->connectDB();
            $sql = "SELECT * FROM ".$this->table_name." WHERE ";
            $name = get_class($this);

            foreach($primaryKeys as $key => $value){
                $sql .=$key."= :".$key." AND ";
            }

            $sql = substr($sql , 0 , -4);
            $stmt = $db->prepare($sql);

            foreach($primaryKeys as $key => $value){
                $stmt->bindParam(":".$key , $value,ValueCheck::showPDOType(array($key => $value), $this->variablesTypes));
            }

            try{
                if($stmt->execute()){
                    while($obj = $stmt->fetch(PDO::FETCH_OBJ)){
                    $instance = new $name();
                    $instanceVars = $this->variablesTypes;

                    if(!is_bool($obj)){
                        foreach($instanceVars as $key => $value){
                            $instance->{$key} = $obj->{$key};
                        }
                    }
                    $instance->new = false;
                    array_push($models,$instance);
                } }
                if(count($models) > 0){
                      return $models;
                }
                else{
                    return false;
                }
            }
            catch(Exception $e){
                $_SESSION["error"] = array("type"=>"error","message"=>$e->getMessage());
            }
        }
        return false;
    }


    /**
     *We can do something with data after save.
     */
    protected function afterSave(){
        $this->plugins->afterSave();
    }

    /**
     * We can do something with data before save.
     * @param $model
     */
    protected function beforeSave(&$model){
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

}
