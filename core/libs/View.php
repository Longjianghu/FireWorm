<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-13
 * Time: 09:32
 */

namespace core\libs;

class View
{
    public static function render(string $file, array $data = [])
    {
        $cacheDir = RUN_PATH.'/cache';

        if ( ! is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }

        if (stripos($file, 'twig') === false) {
            $file = sprintf('%s.twig', $file);
        }

        $viewPath = APP_PATH.'/'.Config::item('viewDir');
        $path     = $viewPath.'/'.$file;

        if (is_file($path)) {
            $loader = new \Twig_Loader_Filesystem($viewPath);

            return (new \Twig_Environment($loader, ['cache' => $cacheDir, 'debug' => DEBUE]))->render($file, $data);
        }
    }
}