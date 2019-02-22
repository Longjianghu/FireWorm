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
// 默认控制器
//----------------------------------

namespace App\Controllers;

use Fireworm\Core\Controller;
use Fireworm\Core\View;

class Home extends Controller
{
    /**
     * 默认首页
     *
     * @access public
     * @return void
     */
    public function index()
    {
        $data = [
            'title'   => 'Fireworm',
            'content' => '一款简单的PHP开发框架!',
        ];

        return View::render('home/index', $data);
    }
}