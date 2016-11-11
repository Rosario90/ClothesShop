<?php

class Category
{
    protected $id;
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public static function getAll()
    {
        return Db::getInstance()->fetchObjects(
            "SELECT id, name FROM categories",
            array(),
            self::class
        );
    }
}