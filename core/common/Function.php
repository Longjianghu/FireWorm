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

if ( ! function_exists('showError')) {
    function showError(string $message, int $status = 404)
    {
        echo $message;
        exit();
    }
}