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
        $route = new \core\libs\route();

        $controller = $route->fetchController();
        $method     = $route->fetchMethod();

        $file = sprintf('%s/controller/%s', APP_PATH, $route->filename());

        if (is_file($file)) {
            include_once $file;

            $ctlClass  = '\\app\controller\\';
            $directory = $route->fetchDirectory();

            if ( ! empty($directory)) {
                $ctlClass .= $directory.'\\';
            }

            $ctlClass .= $controller;
            (new $ctlClass())->$method();
        }
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

    public function display($template, $data = [])
    {
        $file = sprintf('%s/view/%s.php', APP_PATH, $template);

        if (is_file($file)) {
            if ( ! empty($data)) {
                extract($data);
            }

            include_once $file;
        }
    }
}