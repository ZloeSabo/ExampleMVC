<?php

namespace Core\DB;

class ModelRepository
{
    protected $manager;

    public function getConnection($connectionName = '')
    {
        return $this->manager->getConnection($connectionName);
    }
}
