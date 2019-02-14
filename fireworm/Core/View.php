<?php
// +----------------------------------------------------------------------
// | FireWorm [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.sohocn.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://opensource.org/licenses/MIT )
// +----------------------------------------------------------------------
// | Author: longjianghu <215241062@qq.com>
// +----------------------------------------------------------------------

//----------------------------------
// 视图层
//----------------------------------

namespace FireWorm\Core;

class View
{
    /**
     * 初始化.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

    }

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