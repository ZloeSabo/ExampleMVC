<?php

namespace Core\Routing;

class Route {
    protected $name;
    protected $path = '/';
    protected $options = array();
    protected $parameters = array();

    public function __construct($name, $path, array $options = array())
    {
        $this->name = $name;
        $this->path = '/' . ltrim(trim($path), '/');
        // var_dump($this->path); exit;
        $this->options = $options;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function prepareParameters()
    {
        $matches = array();

        preg_match_all('/{([^}]+)}/', $this->path, $matches);

        return $matches[1];
    }

    public function getParameters()
    {
        if(!$this->parameters) {
            $this->parameters = $this->prepareParameters();
        }

        return $this->parameters;
    }

    public function getMatchRegexp()
    {
        $searches = array();
        $replaces = array();

        foreach ($this->getParameters() as $parameter) {
            $searches[] = '{' . $parameter . '}';
            $replaces[] = '(?P<' . $parameter . '>.+)';
        }

        $searches[] = '/';
        $replaces[] = '\/';

        $result = ltrim($this->getPath(), '/');

        $result = str_replace($searches, $replaces, $result);
        $result = '/' . $result . '/';
        // $result = ltrim($result, '/');

        return $result;
    }
}
