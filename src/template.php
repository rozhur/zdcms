<?php

require 'lang.php';

function zdcms_template_build_url($url, array $data)
{
    $built_url = $data['root'] . $url;
    if (isset($data['url']['version'][$url]))
    {
        $built_url .= '?v=' . $data['url']['version'][$url];
    }
    return $built_url;
}

function zdcms_template_render_body(array $data)
{
    foreach ($data['body'] as $class => $template)
    {
        echo '<div class="' . $class . '">';
        if (is_array($template))
        {
            foreach ($template as $t)
            {
                @include 'template/' . $t . '.html.php';
            }
        }
        else
        {
            @include 'template/' . $template . '.html.php';
        }
        echo '</div>';
    }
}

/**
 * @var array $data
 */
?>

<!DOCTYPE html>
<html lang="<?= $data['lang'] ?>">
    <head>
        <title><?= $data['title'] ?></title>
        <link rel="stylesheet" href="<?= zdcms_template_build_url('css/zdcms/style.css', $data) ?>">
        <script type="text/javascript" src="<?= zdcms_template_build_url('js/zdcms/script.js', $data) ?>" defer></script>
        <style><?php require 'template/style.css.php' ?></style>
        <script><?php require 'template/script.js.php' ?></script>
    </head>
    <body><?php zdcms_template_render_body($data) ?></body>
</html>
