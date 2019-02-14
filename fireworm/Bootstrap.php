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
// 引导文件
//----------------------------------

declare(strict_types=1);

namespace FireWorm;

use App\Controllers\HomeController;

class Bootstrap
{
    /**
     * 启动方法
     *
     * @access public
     * @return void
     */
    public static function run(): void
    {
        echo (new HomeController())->index();
    }
}