<?php

function zdcms_module_handle(callable $callback, $name, array &$data, $priority = 0)
{
    $handlers = &$data['handlers'];
    $priorities = &$handlers[$name];
    $priorities[$priority][] = $callback;
    $priorities['size']++;
}

function zdcms_module_fire($name, array &$data, &$handler_data = null)
{
    if (isset($data['handlers'][$name]))
    {
        return;
    }

    $priorities = $data['handlers'][$name];
    foreach ($priorities as $priority)
    {
        $priority_size = $priority['size'];
        for ($i = 0; $i < $priority_size; $i++)
        {
            $callback = $priority[$i];
            $result = $callback($data, $handler_data);
            if ($result === false) break 2;
        }
    }
}

function zdcms_module_require_module($module_file)
{
    require $module_file;
}

function zdcms_module_scan($dir, array &$data)
{
    $module_dirs = scandir($dir);
    if (!$module_dirs) return;

    foreach ($module_dirs as $module_file)
    {
        if ($module_file[0] == '.') continue;

        $module_file = $dir . '/' . $module_file;
        if (!is_dir($module_file)) continue;

        $module_php = $module_file . '/module.php';
        if (file_exists($module_php)) zdcms_module_require_module($module_php);
        else zdcms_module_scan($module_file, $data);
    }
}

function zdcms_module_init()
{
    $data = [
        'handlers' => []
    ];

    $modules_dir = __DIR__ . '/modules';
    zdcms_module_scan($modules_dir, $data);

    return $data;
}
