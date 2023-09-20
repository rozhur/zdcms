<?php

function zdcms_lang_require($lang)
{
    $path = __DIR__ . '/lang/' . $lang . '.php';
    if (file_exists($path))
    {
        require $path;
        return true;
    }
    else
    {
        return false;
    }
}

function zdcms_lang_get_phrase($key, array &$data, $lang = null, $empty_if_not_exists = false)
{
    if ($lang === null)
    {
        $lang = isset($data['lang']) ? $data['lang'] : 'default';
    }

    if (isset($data['langs'][$lang]['phrases']))
    {
        $phrases = $data['langs'][$lang]['phrases'];
    }
    else
    {
        $phrases = [];
        if (!zdcms_lang_require($lang))
        {
            return zdcms_lang_get_phrase($key, $data, 'default', $empty_if_not_exists);
        }

        $data['langs'][$lang]['phrases'] = $phrases;
    }

    if (isset($phrases[$key]))
    {
        return $phrases[$key];
    }
    
    if ($lang === 'default')
    {
        return $empty_if_not_exists ? '' : $key;
    }

    return zdcms_lang_get_phrase($key, $data, 'default', $empty_if_not_exists);
}