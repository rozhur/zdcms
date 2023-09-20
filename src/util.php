<?php

function zdcms_splitld($string, &$letters, &$digits)
{
    $flag = false;
    $strlen = strlen($string);
    for ($i = 0; $i < $strlen; $i++)
    {
        $char = $string[$i];
        if (is_numeric($char))
        {
            $flag = true;
            $digits .= $char;
        }
        else
        {
            if ($flag) break; // when letter after digits
            $letters .= $char;
        }
    }
}