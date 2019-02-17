<?php
// +----------------------------------------------------------------------
// | Fireworm [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.sohocn.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://opensource.org/licenses/MIT )
// +----------------------------------------------------------------------
// | Author: longjianghu <215241062@qq.com>
// +----------------------------------------------------------------------

//----------------------------------
// 控制器
//----------------------------------

namespace Fireworm\Core;

class Controller
{
    public $request;

    /**
     * 初始化.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * 视图渲染
     *
     * @access public
     * @param string $file  模板文件
     * @param array  $data  渲染数据
     * @param bool   $cache 返回数据
     * @return string|void
     */
    public function render(string $file, array $data = [], $cache = false)
    {
        $cachePath = RUN_PATH.'/twig';

        if ( ! is_dir($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        if (stripos($file, 'twig') === false) {
            $file = sprintf('%s.twig', $file);
        }

        $viewPath = APP_PATH.'/'.Config::item('viewPath');
        $path     = $viewPath.'/'.$file;

        if (is_file($path)) {
            $loader = new \Twig_Loader_Filesystem($viewPath);

            $twig = (new \Twig_Environment($loader, [
                'cache' => $cachePath,
                'debug' => (APP_ENV == 'dev') ? true : false
            ]));

            return ( ! empty($cache)) ? $twig->render($file, $data) : $twig->display($file, $data);
        }
    }
}