<?php

namespace Core;

use Core\Routing\Router;
use Core\Routing\RouteConfigLoader;
use Core\DB\DBManager;
use Core\DB\DBConfigLoader;
use Core\Http\Request\RequestInterface;
use Core\Templating\Templating;
use Core\Http\Response\Response;

class AppCore 
{

    protected $router;
    protected $templating;
    protected $db;

    public function __construct()
    {
        // set_error_handler(array($this, 'handleError'));
        register_shutdown_function(array($this, 'handleShutdown'));

        $this->templating = new Templating();

        try {
            $configLoader = new RouteConfigLoader(DirectoryResolver::instance()->getConfigFilePath('routing.xml'));
            $this->router = new Router($configLoader);
        } catch(\Exception $e) {
            $this->handleError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
        }

        try {
            $configLoader = new DBConfigLoader(DirectoryResolver::instance()->getConfigFilePath('database.xml'));
            $this->db = new DBManager($configLoader);
        } catch (\Exception $e) {
            $this->handleError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
        }



    }

    public function handleRequest(RequestInterface $request)
    {
        try {
            $route = $this->router->match($request);

            //TODO move this stuff to separate class
            $routeParameters = $route->getParameters();
            try {
                $controllerClass = new \ReflectionClass('Controllers\\' . $route->getController().'Controller');
            } catch (\Exception $e) {
                throw new CoreException(sprintf("Controller %s does not exist", $route->getController()));
            }

            try {
                $actionName = lcfirst($route->getAction()) . 'Action';
                $action = $controllerClass->getMethod($actionName);
            } catch (\Exception $e) {
                throw new CoreException(sprintf("Action %s does not exist for controller %s", $actionName, $route->getController()));
            }
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

            $dbProperty = $controllerClass->getProperty('db');
            $dbProperty->setAccessible(true);
            $dbProperty->setValue($controllerInstance, $this->db);

            $response = $action->invokeArgs($controllerInstance, $actionParameters);
            
            //TODO capture output and show in shutdown function
            echo $response;
        } catch (\Exception $e) {
            $this->handleError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
        }

    }

    public function handleError($errno, $errstr, $errfile, $errline)
    {
        // var_dump($errno, !(error_reporting() & $errno), $errstr, $errfile, $errline); exit;
        if (!(error_reporting() & $errno)) {
            return;
        }
        $backtrace = array_reverse(debug_backtrace());

        //TODO show error backtrace

        $errorContent = $this->templating->render('', array(
            'content' => 'Something went wrong: ' . $errstr,
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
        exit;
    }
}
