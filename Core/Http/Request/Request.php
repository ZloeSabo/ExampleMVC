<?php

namespace Core\Http\Request;

use Core\ParameterStorage;

class Request implements RequestInterface 
{

    public $post;
    public $get;
    public $attributes;
    public $cookies;
    public $files;
    public $server;
    protected $content;

    protected $requestUri;
    protected $pathInfo;

    private function __construct(array $post = array(), array $get = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->post = new ParameterStorage($post);
        $this->get = new ParameterStorage($get);
        $this->attributes = new ParameterStorage($attributes);
        $this->cookies = new ParameterStorage($cookies);
        $this->files = $files;
        $this->server = new ParameterStorage($server);
        $this->content = $content;
    }

    public static function createFromGlobals()
    {
        return new static($_POST, $_GET, array(), $_COOKIE, $_FILES, $_SERVER);
    }

    public function preparePathInfo()
    {
        return parse_url($this->getRequestUri(), PHP_URL_PATH);
    }

    public function getPathInfo()
    {
        if(!$this->pathInfo) {
            $this->pathInfo = $this->preparePathInfo();
        }
        
        return $this->pathInfo;
    }

    /**
    * Lots of magic with getting right request uri. This one taken from drupal
    */
    public function prepareRequestUri()
    {
        if ($this->server->has('REQUEST_URI')) {
            $uri = $this->server->get('REQUEST_URI');
        } else {
            if ($this->server->has('argv')) {
                $argv = $this->server->get('argv');
                $uri = $this->server->get('SCRIPT_NAME') . '?' . $argv[0];
            } elseif ($this->server->has('QUERY_STRING')) {
                $uri = $this->server->get('SCRIPT_NAME') . '?' . $this->server->get('QUERY_STRING');
            } else {
                $uri = $this->server->get('SCRIPT_NAME');
            }
        }

        $uri = '/' . ltrim($uri, '/');

        return $uri;
    }

    public function getRequestUri() 
    {
        if(!$this->requestUri) {
            $this->requestUri = $this->prepareRequestUri();
        }

        return $this->requestUri;
    }

    public function isAjaxRequest()
    {
        return 'xmlhttprequest' == strtolower($this->server->get('HTTP_X_REQUESTED_WITH'));
    }

    public function getContent()
    {
        if($this->content == null) {
            $this->content = file_get_contents('php://input');
        }

        return $this->content;
    }

}
