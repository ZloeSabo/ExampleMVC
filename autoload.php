<?php

require_once __DIR__ . DS . 'Core' . DS . 'SplClassLoader.php';

//TODO make loader to load multiple namespaces with single instance
$classLoader = new \Core\SplClassLoader('Core', __DIR__);
$classLoader->register();

$controllersLoader = new \Core\SplClassLoader('Controllers', __DIR__);
$controllersLoader->register();

$repositoryLoader = new \Core\SplClassLoader('Repository', __DIR__);
$repositoryLoader->register();
