<?php

class Autoloader
{
    protected $paths = [
        'controllers',
        'models',
        'services',
        'traits'
    ];

    public function getClass($className)
    {
        foreach ($this->paths as $path) {
            $filename = "{$path}/{$className}.php";
            if (file_exists($filename)) {
                include $filename;
                break;
            }
        }
    }
}