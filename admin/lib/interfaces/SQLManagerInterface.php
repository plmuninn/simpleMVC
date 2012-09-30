<?php
/**
 * Interface for SQLManager class
 */
/**
 * Interface for SQLManager class
 * @package interfaces
 */
interface SQLManagerInterface
{
    /**
     * Return object from database by $primaryKeys
     * @abstract
     * @param $primaryKeys
     * @return mixed
     */
    public function getById($primaryKeys);

    /**
     * Method return one object or array with objects from database by $statement
     * @abstract
     * @param $statement
     * @return mixed
     */
    public function getQueryObject($statement);

    /**
     * Make query from $statement. If query return something, it return array else true or false.
     * @abstract
     * @param $statement
     * @return mixed
     */
    public function query($statement);

    /**
     * Return array of all object's in database.
     * @abstract
     * @return mixed
     */
    public function getAll();

    /**
     * Method save or update record with data i database.
     * @abstract
     * @return mixed
     */
    public function save();

    /**
     * Method remove object from database by $primaryKeys
     * @abstract
     * @param $primaryKeys
     * @return mixed
     * @throws Exception
     */
    public function removeById($primaryKeys);

    /**
     * Return array with objects by $primaryKeys
     * @abstract
     * @param $primaryKeys
     * @return mixed
     */
    public function getAllById($primaryKeys);

}
