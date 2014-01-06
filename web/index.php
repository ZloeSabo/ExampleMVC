<?php

use Core\AppCore;
use Core\Http\Request\Request;

define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . '..' . DS . 'autoload.php';

$request = Request::createFromGlobals();
$core = new AppCore();
$core->handleRequest($request);
