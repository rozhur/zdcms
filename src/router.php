<?php

require 'controller.php';

function zdcms_router_run(array &$data)
{
    $data['index'] = $_SERVER['PHP_SELF'];
    $data['root'] = dirname($data['index']);

    $request_method = $_SERVER['REQUEST_METHOD'];

    $data['request'] = [
        'method' => $request_method,
        'post' => $_POST,
        'get' => $_GET
    ];

    $first_param = key($data['request']['get']);
    $first_param = substr($first_param, 1);
    zdcms_splitld($first_param, $controller, $id);

    if (!file_exists($data['dir'] . '/../src/.install-lock.php'))
    {
        $controller = 'install';
    }
    else if (!$controller)
    {
        $controller = 'index';
    }

    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('?', $uri, 2)[0];

    $uri_parts = explode('/', $uri, 2);

    $action = empty($uri_parts[0]) ? 'index' : $uri_parts[0];

    zdcms_controller_run($data, $controller, $action);
}