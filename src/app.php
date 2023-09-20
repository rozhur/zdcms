<?php

require 'util.php';
require 'db.php';
require 'router.php';

function zdcms_app_run(array &$data)
{
    $config = $data['config'];
    $debug = isset($config['debug']) ? $config['debug'] : false;

    if ($debug)
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    }

    $db = isset($config['db']) ? $config['db'] : [];
    $connection = zdcms_db_install($db);

    $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    if (!$lang)
    {
        $lang = 'en';
    }
    else
    {
        $lang = substr($lang, 0, 2);
    }

    $fallback_title = isset($config['title']) ? $config['title'] : 'zdcms';

    $data['debug'] = $debug;
    $data['connection'] = $connection;
    $data['title'] = $fallback_title;
    $data['lang'] = $lang;

    zdcms_router_run($data);
}