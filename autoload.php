<?php

require_once __DIR__ . DS . 'Core' . DS . 'SplClassLoader.php';

$classLoader = new \Core\SplClassLoader('Core', __DIR__);
$classLoader->register();
