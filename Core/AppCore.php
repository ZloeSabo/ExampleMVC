<?php

namespace Core;

use Core\Routing\Router;
use Core\Routing\RouteConfigLoader;
use Core\Http\Request\RequestInterface;
use Core\Templating\Templating;
use Core\Http\Response\Response;

class AppCore 
{

    protected $router;
    protected $templating;

    public function __construct()
    {
        set_error_handler(array($this, 'handleError'));
        register_shutdown_function(array($this, 'handleShutdown'));

        $configLoader = new RouteConfigLoader(DirectoryResolver::instance()->getConfigFilePath('routing.xml'));
        $this->router = new Router($configLoader);
        $this->templating = new Templating();

    }

    public function handleRequest(RequestInterface $request)
    {
        $route = $this->router->match($request);

        //TODO move this stuff to separate class
        $routeParameters = $route->getParameters();
        $controllerClass = new \ReflectionClass('Controllers\\' . $route->getController().'Controller');
        $action = $controllerClass->getMethod(lcfirst($route->getAction()) . 'Action');
        $parameters = $action->getParameters();

        $actionParameters = array();
        if(count($parameters)) {
            $actionParameters = array_map(function($actionParameterName) use($routeParameters) { 
                return $routeParameters[$actionParameterName->getName()];
            }, $parameters);
        }

        $controllerInstance = $controllerClass->newInstance();

        $templatingProperty = $controllerClass->getProperty('templating');
        $templatingProperty->setAccessible(true);
        $templatingProperty->setValue($controllerInstance, $this->templating);

        $response = $action->invokeArgs($controllerInstance, $actionParameters);

        echo $response;
    }

    public function handleError($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return;
        }
        $backtrace = array_reverse(debug_backtrace());

        //TODO show error backtrace

        $errorContent = $this->templating->render('', array(
            'content' => 'Something went wrong ' //. implode('<br/>', $backtrace),
        ));

        echo new Response($errorContent, 500);
        exit;
    }

    public function handleShutdown()
    {
        $error = error_get_last();

        if($error !== null) {
            $this->handleError($error['type'], $error['message'], $error['file'], $error['file']);
        }
    }
}
