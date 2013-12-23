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

        //TODO move this stuff to separate class
        $routeParameters = $route->getParameters();
        $controllerClass = new \ReflectionClass('Controllers\\' . $route->getController().'Controller');
        $action = $controllerClass->getMethod(lcfirst($route->getAction()) . 'Action');
        $parameters = $action->getParameters();

        $actionParameters = array();
        if(count($parameters)) {
            $actionParameters = array_map(function($actionParameterName) use($routeParameters) { 
                return $routeParameters[$actionParameterName->getName()];
            }, $parameters);
        }

        $controllerInstance = $controllerClass->newInstance();
        $action->invokeArgs($controllerInstance, $actionParameters);
    }

}
