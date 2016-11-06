<?php

class Category extends Model
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
        return self::getConnection()->fetchObjects(
            "SELECT id, name FROM categories",
            array(),
            self::class
        );
    }
}