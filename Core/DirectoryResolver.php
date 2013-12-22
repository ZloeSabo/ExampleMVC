<?php

namespace Core;

class DirectoryResolver
{
    protected static $resolver;

    protected $root;

    private function __construct()
    {
        $this->root = realpath(__DIR__ . DS . '..');
    }

    public function instance()
    {
        if(!self::$resolver) {
            self::$resolver = new self();
        }

        return self::$resolver;
    }

    public function getConfigFilePath($file)
    {
        return $this->root . DS . 'config' . DS . $file;
    }
}
