<?php

/**
 * @var array $data
 */

if ($data['debug'])
{
    ?>
console.log(<?=json_encode($data)?>)
    <?php
}
