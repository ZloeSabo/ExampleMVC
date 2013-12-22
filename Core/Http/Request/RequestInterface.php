<?php

namespace Core\Http\Request;

interface RequestInterface
{
    public function getPathInfo();
    public function getRequestUri();
}
