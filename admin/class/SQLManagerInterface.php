<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 31.05.12
 * Time: 07:44
 *
 */
interface SQLManagerInterface
{
    /**
     * @abstract
     * @param $primaryKeys
     * @return mixed
     */
    public function getById($primaryKeys);

    /**
     * @abstract
     * @param $statement
     * @return mixed
     */
    public function getQueryObject($statement);

    /**
     * @abstract
     * @param $statement
     * @return mixed
     */
    public function query($statement);

    /**
     * @abstract
     * @return mixed
     */
    public function getAll();

    /**
     * @abstract
     * @return mixed
     */
    public function save();

    /**
     * @abstract
     * @param $primaryKeys
     * @return mixed
     * @throws Exception
     */
    public function removeById($primaryKeys);

    /**
     * @abstract
     * @param $primaryKeys
     * @return mixed
     */
    public function getAllById($primaryKeys);

}
