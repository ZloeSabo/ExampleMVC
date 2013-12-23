<?php

namespace Core\Routing;

class RouteMatcher {

    protected $routes;

    public function __construct(array &$routes = array())
    {
        $this->routes = $routes;
    }

    public function match($path)
    {
        foreach ($this->routes as $route) {
            if($route->match($path)) {
                return $route;
            }
        }
    }


}
