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
// 默认控制器
//----------------------------------

namespace App\Controllers;

use FireWorm\Core\Controller;

class HomeController extends Controller
{
    /**
     * 默认首页
     *
     * @access public
     * @return void
     */
    public function index(): void
    {
        $data = [
            'title'   => 'FireWorm',
            'content' => '一款简单的PHP开发框架!',
        ];

        return $this->render('home/index', $data);
    }
}