<?php

namespace Core\DB;

interface DBDriverInterface
{
    public function buildDSN($params);
    public function query($query, $params);
}
