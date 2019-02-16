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
// 引导文件
//----------------------------------

declare(strict_types=1);

namespace Fireworm;

use Fireworm\Core\DotEnv;
use Fireworm\Core\Logs;
use Fireworm\Core\Route;

class Bootstrap
{
    /**
     * 启动方法
     *
     * @access public
     * @return void
     */
    public static function run()
    {
        try {
            // 加载环境变量
            (new DotEnv(ROOT_PATH))->load();

            // 解析路由
            $route = new Route();

            $controller = $route->fetchController();
            $method     = $route->fetchMethod();

            $class = sprintf('%s\%s', $route->fetchNameSpace(), $controller);
            $class = str_replace('\\\\', '\\', $class);

            if ( ! class_exists($class)) {
                throw new \Exception($controller.'类未定义！');
            }

            if ( ! method_exists($class, $method)) {
                throw new \Exception($method.'方法未定义！');
            }

            (new $class())->$method();
        } catch (\Throwable $e) {
            (new Logs())::addUserLog($e->getMessage(), [], false);

            echo $e->getMessage();
        }
    }
}