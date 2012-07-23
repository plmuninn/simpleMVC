<?php
/**
 * Check values for model.
 */

/**
 * Class check if variables are of good type and length.
 * @package core
 * @subpackage model
 */
class ValueCheck
{
    /**
     *Empty.
     */
    function __construct()
    {
    }

    /**
     *Empty.
     */
    function __destruct()
    {
    }

   /**
    * Method check a type and length variable
    *@param array $valueArr array with variable, name and value
    *@param array $typeArr  array with type of variable, name and value
    *@return bool*/
    public static function isGoodType($valueArr, $typeArr){
          $key = key($valueArr);
          $prefLength = intVal(preg_replace("/[^0-9]/", '', $typeArr[$key]));  /*Get length of variable*/
          $type = preg_replace("/[^A-Za-z]/", '', $typeArr[$key]);       /*Get type of variable*/
          $value =$valueArr[$key];      /*Get varieble*/

         /*Check if is empty*/
        if(count($value) != 0 && $value != ''){
                //echo $type." ".$value."<br />";
             switch($type){
                 case "int":
                     if(is_numeric($value)){
                           return true;
                     }
                     else
                         return false;
                     break;
                 case "char":
                     if(is_string($value)){
                         if(count($value) >= 0 && count($value) <= $prefLength && count($value) <= 255){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "varchar":
                     if(is_string($value)){
                         if(count($value) >= 0 && count($value) <= $prefLength && count($value) <= 255){
                         return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "tinytext":
                     if(is_string($value)){
                         if(count($value) <= $prefLength && count($value) <= 255){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "text":
                     if(is_string($value)){
                         if(count($value) <= $prefLength  && count($value) <= 65535){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "blob":
                     if(is_string($value)){
                         if(count($value) <= $prefLength  && count($value) <= 65535){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "mediumtext":
                     if(is_string($value)){
                         if(count($value) <= $prefLength  && count($value) <= 16777215){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "mediumblob":
                     if(is_string($value)){
                         if(count($value) <= $prefLength  && count($value) <= 16777215){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "longtext":
                     if(is_string($value)){
                         if(count($value) <= $prefLength  && count($value) <= 4294967295){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "longblob":
                     if(is_string($value)){
                         if(count($value) <= $prefLength  && count($value) <= 4294967295){
                             return true;
                         }
                     }
                     else
                         return false;
                     break;
                 case "decimal":
                     if(is_double($value)){
                         return true;
                     }
                     else
                         return false;
                     break;
             }
        }
            return false;
    }

    /**
     * Return PDO::PARAM type
     * @static
     * @param array $valueArr array with variable, name and value
     * @param array $typeArr  array with type of variable, name and value
     * @return mixed
     */
    public static function  showPDOType($valueArr, $typeArr){
        $key = key($valueArr);
        $type = preg_replace("/[^A-Za-z]/", '', $typeArr[$key]);       /*Get type of variable*/
        $value =$valueArr[$key];      /*Get varieble*/

        if(count($value) != 0 && $value != ''){
            switch($type){
                case "int":
                    if(is_numeric($value)){
                        return PDO::PARAM_INT;
                    }
                    else
                        return false;
                    break;
                case "varchar":
                    if(is_string($value)){
                        return PDO::PARAM_STR;
                    }
                    else
                        return false;
                    break;
                case "decimal":
                    if(is_double($value)){
                       return PDO::PARAM_STR;
                    }
                    else
                        return false;
                    break;
            }
        }

    }
}
