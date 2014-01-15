<?php

namespace Core\Controller;

use Core\Http\Response\Response;

class Controller
{
    protected $templating;
    protected $db;
    protected $request;

    protected function render($template, $variables, $layout = 'layout.html.php')
    {
        $content = $this->templating->render($template, $variables, $layout);
        return new Response($content);
    }   
}
