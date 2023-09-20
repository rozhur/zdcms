<?php

require 'module.php';
require 'zdcms/app.php';

function zdcms_exception_handler($exception) {
    echo '<pre>';
    echo $exception;
    echo '</pre>';
}

function zdcms_error_handler($errno, $errstr, $errfile, $errline)
{
    echo '<pre>';
    echo 'An error occurred with code ' . $errno . ': ' . $errstr . ' in ' . $errfile . ':' . $errline;
    echo '</pre>';
}

function zdcms_config_install() {
    $config = [];
    require '../config.php';
    return $config;
}

function zdcms_main($dir)
{
    set_error_handler('zdcms_error_handler');
    set_exception_handler('zdcms_exception_handler');

    $config = zdcms_config_install();

    $data = zdcms_module_init();

    $controllers = [];
    require '.controllers.php';
    $data['controllers'] = $controllers;

    $data['config'] = $config;
    $data['dir'] = $dir;

    zdcms_app_run($data);
}