<?php

namespace Core\Routing;

class RouteGenerator
{
    protected $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function generate($name, array $parameters = array())
    {
        if(!isset($this->routes[$name])) {
            throw new RoutingException(sprintf("No route configured for %s", $name));
        }

        return $this->routes[$name]->generate($parameters);
    }
}
