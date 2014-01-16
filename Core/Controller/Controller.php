<?php

namespace Core\Controller;

use Core\Http\Response\Response;

class Controller
{
    // protected $templating;
    // protected $db;
    // protected $request;
    protected $registry = array();

    protected function render($template, $variables, $layout = 'layout.html.php')
    {
        $content = $this->get('templating')->render($template, $variables, $layout);
        return new Response($content);
    }

    protected function get($service)
    {
        return $this->registry[$service];
    }   
}
