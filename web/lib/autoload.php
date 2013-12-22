<?php

spl_autoload_register(function($className)
{
    $filePath = __DIR__  . '/' . str_replace(array('_', '\\'), '/', $className) . '.php';

    if(!file_exists($filePath))
    {
        return false;
    }
    require($filePath);
});