<?php

namespace Core\DB\Helper;

class NamedParametersPreparer
{
    public static function prepare(array $entity = array())
    {
        $properties = array_keys($entity);
        $placeholders = array_map(function($property) {
            return sprintf('%s = :%s', $property, $property);
        }, $properties);

        return implode(', ', $placeholders);
    }
}
