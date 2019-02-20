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
// 视图层
//----------------------------------

namespace Fireworm\Core;

use Fireworm\Exceptions\ErrorException;

class View
{
    /**
     * 视图渲染
     *
     * @access public
     * @param string $filename 模板文件
     * @param array  $data     渲染数据
     * @param bool   $cache    返回数据
     * @return string|void
     */
    public static function render(string $filename, array $data = [], $cache = false)
    {
        $cachePath = RUN_PATH.'/twig';

        if ( ! is_dir($cachePath)) {
            @mkdir($cachePath, 0777, true);
        }

        if (stripos($filename, 'twig') === false) {
            $filename = sprintf('%s.twig', $filename);
        }

        $viewPath = APP_PATH.'/'.Config::item('viewPath');
        $path     = $viewPath.'/'.$filename;

        if ( ! is_file($path)) {
            throw new ErrorException('视图文件'.$filename.'不存在！');
        }

        $loader = new \Twig_Loader_Filesystem($viewPath);

        $twig = (new \Twig_Environment($loader, [
            'cache' => $cachePath,
            'debug' => (APP_ENV == 'dev') ? true : false
        ]));

        return ( ! empty($cache)) ? $twig->render($filename, $data) : $twig->display($filename, $data);
    }
}