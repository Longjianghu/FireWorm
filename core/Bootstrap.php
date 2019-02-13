<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:36
 */

namespace core;

class Bootstrap
{
    public static $isLoad = [];

    public static function run()
    {
        $route = new \core\libs\route();

        $controller = $route->fetchController();
        $method     = $route->fetchMethod();
        $directory  = $route->fetchDirectory();

        $filename = sprintf('%s/%s', APP_PATH, $route->filename());

        if (is_file($filename)) {
            include_once $filename;

            $ctlClass = '\\app\controller\\';

            if ( ! empty($directory)) {
                $ctlClass .= str_replace('/', '\\', $directory).'\\';
            }

            $ctlClass .= $controller;
            (new $ctlClass())->$method();
        }
    }

    public static function loadClass(string $class)
    {
        $class = str_replace('\\', '/', $class);

        if (isset(self::$isLoad[$class])) {
            return;
        }

        $filename = ROOT_PATH.'/'.$class.'.php';

        if (is_file($filename)) {
            include_once $filename;
            self::$isLoad[$class] = 1;
        }
    }
}