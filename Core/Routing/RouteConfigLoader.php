<?php

namespace Core\Routing;

use Core\ConfigLoader\Xml\XmlConfigLoader;

class RouteConfigLoader extends XmlConfigLoader
{
    protected $routeInfo = array();

    public function load()
    {
        if(!$this->routeInfo) {
            $xml = parent::load();

            foreach ($xml->route as $route) {
                $this->routeInfo[(string)$route->name] = array(
                    'path' => (string)$route->path,
                    'controller' => (string)$route->controller,
                    'action' => (string)$route->action
                );
            }
        }

        return $this->routeInfo;
    }
}
