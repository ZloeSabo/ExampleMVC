<?php

namespace Core;

use Core\Routing\Router;
use Core\Routing\RouteConfigLoader;
use Core\Http\Request\RequestInterface;

class AppCore {

    protected $router;

    public function __construct()
    {
        $configLoader = new RouteConfigLoader(DirectoryResolver::instance()->getConfigFilePath('routing.xml'));
        $this->router = new Router($configLoader);
    }

    public function handleRequest(RequestInterface $request)
    {
        $route = $this->router->match($request);
    }

}
