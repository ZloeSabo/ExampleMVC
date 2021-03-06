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
    protected $routeGenerator;
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
        $this->routeGenerator = new RouteGenerator($this->routes);
    }

    public function match(RequestInterface $request)
    {
        $matchedRoute = $this->routeMatcher->match($request->getPathInfo());
        if(empty($matchedRoute)) {
            throw new RoutingException(sprintf("No route configured for %s", $request->getPathInfo()));
        }

        return $matchedRoute;
    }

    public function generate($name, array $parameters = array())
    {
        return $this->routeGenerator->generate($name, $parameters);
    }
}
