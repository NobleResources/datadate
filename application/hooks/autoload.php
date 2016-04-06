<?php

function autoload()
{
    spl_autoload_register(function ($className) {

        if (empty($className)) {
            return false;
        }

        $className = str_replace('DataDate\\', '', $className);
        $className = str_replace('\\', '/', $className);

        $fileName = __DIR__ . '/../classes/' . $className . '.php';

        if (file_exists($fileName)) {
            require $fileName;
            return true;
        }

        return false;
    });
}


