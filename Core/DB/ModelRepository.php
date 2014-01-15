<?php

namespace Core\DB;

class ModelRepository
{
    protected $manager;
    protected $modelName;

    public function getConnection($connectionName = '')
    {
        return $this->manager->getConnection($connectionName);
    }

    public function find($id)
    {

        $result = $this->getConnection()
            ->query(
                sprintf('SELECT * FROM %s WHERE id = :id LIMIT 0, 1', $this->modelName), 
                array('id' => $id)
            )
        ;

        return empty($result) ? null : $result[0];
    }
}
