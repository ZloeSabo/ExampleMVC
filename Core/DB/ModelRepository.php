<?php

namespace Core\DB;

use Core\DB\Helper\NamedParametersPreparer;

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

    public function findBy(array $parameters = array(), $returnSingle = false)
    {
        $namedParametersString = NamedParametersPreparer::prepare($parameters);

        $query = sprintf(
            $returnSingle ? 'SELECT * FROM %s WHERE %s LIMIT 0, 1' : 'SELECT * FROM %s WHERE %s', 
            $this->modelName, 
            $namedParametersString
        );

        $result = $this->getConnection()
            ->query(
                $query,
                $parameters
            )
        ;

        if($returnSingle) {
            return empty($result) ? null : $result[0];
        } else {
            return $result;
        }
    }

    public function persist(array &$entity = array())
    {
        if(empty($entity)) {
            throw new DBException('Cannot persist empty entity');
        }

        $id = $entity['id'];

        if(is_numeric($id) && intval($id) >= 0) { //Updates existing entity

            unset($entity['id']);

            $namedParametersString = NamedParametersPreparer::prepare($entity);

            $query = sprintf('UPDATE %s SET %s WHERE id = :id', $this->modelName, $namedParametersString);

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

        return $entity;

    }

    public function delete($id)
    {
        $query = sprintf('DELETE FROM %s WHERE id = :id', $this->modelName);

        $this->getConnection()
            ->query(
                $query,
                array('id' => $id)
            )
        ;
    }

    public function __call($name, $arguments)
    {
        if(strpos($name, 'findBy', 0) === 0) {
            $parameterName = strtolower(substr($name, 6));
            return call_user_func(array($this, "findBy"), array($parameterName => $arguments[0]));
        } else if(strpos($name, 'findOneBy', 0) === 0) {
            $parameterName = strtolower(substr($name, 9));
            return call_user_func(array($this, "findBy"), array($parameterName => $arguments[0]), true);
        }
    }
}
