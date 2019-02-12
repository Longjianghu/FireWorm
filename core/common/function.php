<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:35
 */

if ( ! function_exists('p')) {
    function p($obj, $brak = false)
    {
        var_dump($obj);

        if ( ! empty($brak)) {
            exit();
        }
    }
}