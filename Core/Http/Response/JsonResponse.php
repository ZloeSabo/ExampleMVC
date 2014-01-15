<?php

namespace Core\Http\Response;

class JsonResponse extends Response
{
    protected $mimeType = 'application/json';

    public function __construct($content, $code = 200, $mimeType = 'application/json')
    {
        parent::__construct($content, $code, $mimeType);
    }

    public function __toString()
    {
        $content = parent::__toString();

        return json_encode($content);
    }
}
