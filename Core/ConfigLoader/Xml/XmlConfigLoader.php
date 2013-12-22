<?php

namespace Core\ConfigLoader\Xml;

use Core\ConfigLoader\ConfigLoaderInterface;
use Core\ConfigLoader\ConfigLoaderException;

class XmlConfigLoader implements ConfigLoaderInterface
{
    protected $file;
    protected $content;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function load()
    {
        if(!$this->content) {
            $this->content = simplexml_load_file($this->file);
            if(!$this->content instanceof \SimpleXMLElement) {
                throw new ConfigLoaderException('Could not load configuration from ' . $this->file);
            }
        }

        return $this->content;
    }
}
