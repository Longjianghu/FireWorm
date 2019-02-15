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
// 数据库配置文件
//----------------------------------

return [
    'master' => [
        'server'   => env('master.server', '127.0.0.1'),
        'username' => env('master.username', 'root'),
        'password' => env('master.password', ''),
        'database' => env('master.database', 'test'),
        'prefix'   => env('master.prefix', ''),
        'port'     => env('master.port', '3303')
    ],
    'slave'  => [
        'server'   => env('master.server', '127.0.0.1'),
        'username' => env('master.username', 'root'),
        'password' => env('master.password', ''),
        'database' => env('master.database', 'test'),
        'prefix'   => env('master.prefix', ''),
        'port'     => env('master.port', '3303')
    ],
];