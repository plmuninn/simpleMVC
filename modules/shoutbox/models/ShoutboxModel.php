<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 20.07.12
 * Time: 09:42
 *
 */
class ShoutboxModel extends Model
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
}
