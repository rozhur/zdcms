<?php

function zdcms_controller_require_template(array $data)
{
    require 'template.php';
}

function zdcms_controller_run(array &$data, $controller, $action)
{
    if (file_exists($controller_file = __DIR__ . '/controller/' . $controller . '.php'))
    {
        require $controller_file;

        $action_function = 'zdcms_controller_action_' . $action;
        if (!function_exists($action_function))
        {
            if ($data['debug'])
            {
                trigger_error('Action \'' . $action . '\' of controller \'' . $controller . '\' not found', E_USER_ERROR);
            }

            $action = 'index';
        }
        else
        {
            $action_function($data);
        }

        $data['controller'] = $controller;
        $data['action'] = $action;
    }
    else
    {
        if ($data['debug'])
        {
            trigger_error('Controller \'' . $controller . '\' not found', E_USER_ERROR);
        }

        require 'controller/index.php';
        zdcms_controller_action_index($data);

        $data['controller'] = 'index';
        $data['action'] = 'index';
    }

    zdcms_controller_require_template($data);
}