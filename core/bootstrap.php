<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:36
 */

namespace core;

class bootstrap
{
    public static $isLoad = [];

    public static function run()
    {
        $route = new \core\route();
        echo $route->fetchFilename();
    }

    public static function loadClass($class)
    {
        $class = str_replace('\\', '/', $class);

        if (isset(self::$isLoad[$class])) {
            return;
        }

        $file = ROOT_PATH.'/'.$class.'.php';

        if (is_file($file)) {
            include_once $file;

            self::$isLoad[$class] = 1;
        }
    }
}