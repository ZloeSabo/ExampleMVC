<?php

namespace Core\Templating\Helper;

use Core\Routing\Router;

class PathHelper implements HelperInterface
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function path($name, array $parameters = array())
    {
        return $this->router->generate($name, $parameters);
    }

    public function getName()
    {
        return 'path';
    }
}
