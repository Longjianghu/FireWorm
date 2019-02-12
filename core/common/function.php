<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:35
 */

use \core\libs\config;

if ( ! function_exists('p')) {
    function p($obj, $brak = false)
    {
        echo '<pre>';
        var_dump($obj);
        echo '</pre>';
        if ( ! empty($brak)) {
            exit();
        }
    }
}
