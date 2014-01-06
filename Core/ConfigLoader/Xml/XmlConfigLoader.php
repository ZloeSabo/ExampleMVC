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
        if(!file_exists($file)) {
            throw new ConfigLoaderException(sprintf(
                'Configuration file %s does not exist', 
                basename($file)
            ));
        }

        $this->file = $file;
    }

    public function load()
    {
        if(!$this->content) {
            $this->content = simplexml_load_file($this->file);
            if(!$this->content instanceof \SimpleXMLElement) {
                throw new ConfigLoaderException(sprintf(
                    'Could not load configuration from %s',
                    basename($this->file)
                ));
            }
        }

        return $this->content;
    }
}
