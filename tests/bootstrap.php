<?php

spl_autoload_register(function($class)
{
    $file = __DIR__.'/../lib/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});

require_once 'Zend/Loader/Autoloader.php';

Zend_Loader_Autoloader::getInstance();
