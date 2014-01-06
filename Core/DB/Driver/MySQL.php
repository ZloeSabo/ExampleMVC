<?php

namespace Core\DB\Driver;

use Core\DB\DBDriverInterface;

class MySQL implements DBDriverInterface
{
    const DEFAULT_PORT = 3306;
    const DEFAULT_CHARSET = 'utf8';

    private $pdo;
    private $queries = array();
    
    public function __construct($params)
    {
        $dsn = $this->buildDSN($params);
        $this->pdo = new \PDO($dsn, $params['user'], $params['password'], array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => sprintf('SET NAMES %s', isset($params['encoding']) ? $params['encoding'] : self::DEFAULT_CHARSET)
        ));
    }

    public function __destruct()
    {
        //No need to explicitly close pdo connection
        //@see http://www.php.net/manual/en/pdo.connections.php
    }

    public function buildDSN($params)
    {
        $dsn = sprintf('%s:dbname=%s;host=%s;port=%s;charset=%s',
            'mysql',
            $params['database'],
            $params['host'],
            isset($params['port']) ? $params['port'] : self::DEFAULT_PORT,
            isset($params['encoding']) ? $params['encoding'] : self::DEFAULT_CHARSET
        );

        return $dsn;
    }

    public function query($sql, $params = array())
    {
        $hash = crc32($sql);
        if(!isset($this->queries[$hash])) {
            $query = $this->pdo->prepare($sql);
            $this->queries[$hash] = $query;
        } else {
            $query = $this->queries[$hash];
        }

        $query->execute($params);

        return $query->fetchAll();
    }


}
