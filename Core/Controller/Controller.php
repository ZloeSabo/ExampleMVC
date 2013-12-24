<?php

namespace Core\Controller;

use Core\Http\Response\Response;

class Controller
{
    protected $templating;

    protected function render($template, $variables, $layout = 'layout.html.php')
    {
        throw new Exception("Error Processing Request", 1);
        
        $content = $this->templating->render($template, $variables, $layout = 'layout.html.php');
        return new Response($content);
    }   
}
