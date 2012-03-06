<?php

require_once __DIR__.'/../vendor/symfony-components/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
    'Tolerable' => __DIR__.'/../lib',
    'Symfony\Component' => __DIR__.'/../vendor/symfony-components',
    'Guzzle'            => __DIR__.'/../vendor/guzzle/src'
));
$loader->register();

