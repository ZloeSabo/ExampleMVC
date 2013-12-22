<?php

namespace Core\ConfigLoader;

interface ConfigLoaderInterface
{
    public function __construct($file);
    public function load();
}
