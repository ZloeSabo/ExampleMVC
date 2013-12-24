<?php

use Core\AppCore;
use Core\Http\Request\Request;

//For use with builtin php server
if(PHP_SAPI == 'cli') {
    var_dump($_SERVER);
    if (is_file($_SERVER['DOCUMENT_ROOT'] . DS . $_SERVER['SCRIPT_NAME'])) {
        var_dump('wtf');
        return false;
    }

    $_SERVER['SCRIPT_FILENAME'] = __DIR__.'index.php';
}

define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . '..' . DS . 'autoload.php';

$request = Request::createFromGlobals();
$core = new AppCore();
$core->handleRequest($request);
