<?php

namespace Core\Routing;

class RouteMatcher {
    protected $routes;

    public function __construct(array $routes = array())
    {
        $this->routes = $routes;
    }

    public function match($path)
    {
        foreach ($this->routes as $route) {
            $regexp = $route->getMatchRegexp();
            if(preg_match($regexp, $path, $matches) !== false) {
                $namedRouteParameters = $route->getParameters();

                //TODO красиво достать захваченные параметры

                // $result = array_map(function($el) use ($matches) {
                //     return $matches[$el];
                // }, $namedRouteParameters);
                


                var_dump($matches); exit;
            }
        }
    }


}
