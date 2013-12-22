<?php

namespace Core\Routing;

use Core\Http\Request\RequestInterface;
/**
* 
*/
class Router
{
    protected $routes = array();
    protected $routeMatcher;
    protected $correntRoute;
    
    public function __construct(RouteConfigLoader $routeLoader)
    {
        $routeParameters = $routeLoader->load();
        foreach ($routeParameters as $routeName => $routeInfo) {
            $parameters = $routeInfo;
            unset($parameters['path']);
            $this->routes[$routeName] = new Route($routeName, $routeInfo['path'], $parameters);
        }

        $this->routeMatcher = new RouteMatcher($this->routes);
    }

    public function match(RequestInterface $request)
    {
        $matchedRoute = $this->routeMatcher->match($request->getPathInfo());
        $this->currentRoute = $matchedRoute;

        return $matchedRoute;
    }

    public function generate($name, array $parameters = array())
    {

    }
}
