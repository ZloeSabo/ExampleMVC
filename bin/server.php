<?php

defined('DS') || define('DS', DIRECTORY_SEPARATOR);

if(version_compare(phpversion(), '5.4.0', '<')) {
    echo "You're using old php version. Please upgrade to 5.4+ to use built-in server", PHP_EOL;
    exit;
}

passthru(PHP_BINARY . ' -S' . ' localhost:8000 ' . __DIR__ . DS . '..' . DS . 'web' . DS . 'index.php');
