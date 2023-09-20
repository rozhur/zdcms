<?php

function zdcms_db_connect($hostname, $username, $password, $dbname, $port)
{
    $connection = mysqli_init();
    if (!mysqli_real_connect($connection, $hostname, $username, $password, $dbname, $port))
    {
        trigger_error(mysqli_connect_error(), E_USER_ERROR);
    }

    return $connection;
}

function zdcms_db_query($connection, $query, array $params = null)
{
    $statement = mysqli_prepare($connection, $query);
    if (!$statement ||
        $params && !mysqli_stmt_bind_param($statement, str_repeat('s', count($params)), ...$params) ||
        !mysqli_stmt_execute($statement))
    {
        exit(mysqli_stmt_error($statement));
    }

    return $statement;
}

function zdcms_db_result($connection, &$result, $query, array $params = [])
{
    $statement = zdcms_db_query($connection, $query, $params);

    $meta = mysqli_stmt_result_metadata($statement);
    if (!$meta)
    {
        return false;
    }

    $refs = [];
    $values = [];
    $i = 0;

    while ($field = $meta->fetch_field())
    {
        $refs[] = null;
        $ref = &$refs[$i];
        $values[] = &$ref;
        $result[$field->name] = &$ref;
        $i++;
    }

    mysqli_stmt_bind_result($statement, ...$values);

    return $statement;
}

function zdcms_db_fetch($statement)
{
    return mysqli_stmt_fetch($statement);
}