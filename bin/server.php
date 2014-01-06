<?php

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

if(version_compare(phpversion(), '5.4.0', '<')) {
    echo "You're using old php version. Please upgrade to 5.4+ to use built-in server", PHP_EOL;
    exit;
}

$web = __DIR__ . DS . '..' . DS . 'web';

$command = sprintf("%s -S localhost:8000 -t %s %s",
    PHP_BINARY,
    $web,
    __DIR__ . DS . '..' . DS . 'Core' . DS . 'Helper' . DS . 'RoutingHelper.php'
);

passthru($command);
