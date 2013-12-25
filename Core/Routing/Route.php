<?php

namespace Core\Routing;

class Route {
    protected $name;
    protected $path = '/';
    protected $options = array();
    protected $placeholders = array();
    protected $parameters = array();

    public function __construct($name, $path, array $options = array())
    {
        $this->name = $name;
        $this->path = '/' . ltrim(trim($path), '/');
        $this->options = $options;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function preparePlaceholders()
    {
        $matches = array();

        preg_match_all('/{([^}]+)}/', $this->path, $matches);

        return $matches[1];
    }

    public function getPlaceholders()
    {
        if(!$this->placeholders) {
            $this->placeholders = $this->preparePlaceholders();
        }

        return $this->placeholders;
    }

    public function getMatchRegexp()
    {
        $searches = array();
        $replaces = array();

        foreach ($this->getPlaceholders() as $placeholder) {
            $searches[] = '{' . $placeholder . '}';
            $replaces[] = '(?P<' . $placeholder . '>.+)';
        }

        $searches[] = '/';
        $replaces[] = '\/';

        $result = ltrim($this->getPath(), '/');

        $result = str_replace($searches, $replaces, $result);
        $result = '/' . $result . '/';

        return $result;
    }

    public function match($path)
    {
        $matchRegexp = $this->getMatchRegexp();

        if(preg_match($matchRegexp, $path, $matches) == 1) {
            foreach ($this->placeholders as $parameter) {
                //WTF? Undefined index with really existing index
                $this->parameters[$parameter] = @$matches[$parameter];
            }

            return true;
        }

        return false;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getController()
    {
        return $this->options['controller'];
    }

    public function getAction()
    {
        return $this->options['action'];
    }
}
