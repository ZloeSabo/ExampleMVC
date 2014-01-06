<?php

namespace Core\DB;

use Core\ConfigLoader\ConfigLoaderInterface;
use Core\ConfigLoader\Xml\XmlConfigLoader;

class DBConfigLoader extends XmlConfigLoader
{
    protected $config;

    public function load()
    {
        if(!$this->config) {
            $xml = parent::load();

            foreach ($xml->connection as $connection) {
                $name = isset($connection->name) ? (string)$connection->name : 'default';
                $this->config[$name] = array(
                    'host' => (string)$connection->host,
                    'port' => (string)$connection->port,
                    'database' => (string)$connection->database,
                    'user' => (string)$connection->user,
                    'password' => (string)$connection->password,
                    'encoding' => (string)$connection->encoding
                );
            }
        }

        return $this->config;
    }
}
