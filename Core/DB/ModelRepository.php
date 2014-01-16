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

    public function persist(array &$entity = array())
    {
        if(empty($entity)) {
            throw new DBException('Cannot persist empty entity');
        }

        $id = $entity['id'];

        if(is_numeric($id) && intval($id) >= 0) { //Updates existing entity

            $query = sprintf('UPDATE %s SET %s WHERE id = :id', $this->modelName, '%s');
            unset($entity['id']);

            $properties = array_keys($entity);
            $setterStringParts = array_map(function($property) {
                return sprintf('%s = :%s', $property, $property);
            }, $properties);

            $setterString = implode(', ', $setterStringParts);
            $query = sprintf($query, $setterString);

            $entity['id'] = $id;

            $this->getConnection()
                ->query(
                    $query,
                    $entity
                )
            ;

        } else { //Creates new entity
            $query = sprintf('INSERT INTO %s(%s) VALUES (%s)', $this->modelName, '%s', '%s');
            unset($entity['id']);

            $properties = array_keys($entity);
            $placeholders = array_map(function($property) {
                return sprintf(':%s', $property);
            }, $properties);

            $query = sprintf($query, implode(', ', $properties), implode(', ', $placeholders));

            $id = $this->getConnection()
                ->query(
                    $query,
                    $entity
                )
            ;

            $entity['id'] = $id;
        }
    }

    return $entity;
}
