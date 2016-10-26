<?php
class Model
{
    /**
     * @return Db
     */
    public static function getConnection()
    {
        return Db::getInstance();
    }

}