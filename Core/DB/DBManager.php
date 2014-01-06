<?php

namespace Core\DB;

use Core\ConfigLoader\ConfigLoaderInterface;
use Core\DB\Driver\MySQL;

class DBManager
{
    const DEFAULT_DRIVER = 'mysql';

    protected $connections = array();

    public function __construct(ConfigLoaderInterface $configLoader)
    {
        $config = $configLoader->load();

        foreach ($config as $connectionName => $connectionInfo) {
            $this->connections[$connectionName] = $this->createConnection($connectionInfo);
        }
    }

    protected function createConnection($connectionInfo)
    {
        $type = isset($connectionInfo['type']) ? $connectionInfo['type'] : self::DEFAULT_DRIVER;

        switch ($type) {
            case 'mysql':
                return new MySQL($connectionInfo);
                break;
            
            default:
                throw new DBException(sprintf('Support for %s database is not implemented yet', $type));
                break;
        }
    }

    public function getConnection($name = '')
    {
        $name = isset($this->connections[$name]) ? $this->connections[$name] : 'default';

        return $this->connections[$name];
    }
}
