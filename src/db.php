<?php

function zdcms_db_install(array $db)
{
    $driver = isset($db['driver']) ? $db['driver'] : 'none';
    $path = __DIR__ . '/db/' . $driver . '.php';
    if (file_exists($path))
    {
        require $path;
        return zdcms_db_connect($db['hostname'], $db['username'], $db['password'], $db['dbname'], $db['port']);
    }
    else
    {
        trigger_error('Database driver \'' . $driver . '\' not found', E_USER_ERROR);
    }
}