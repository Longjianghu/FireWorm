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
// 数据库配置文件
//----------------------------------

return [
    'master' => [
        'server'       => env('master.server', '127.0.0.1'),
        'username'     => env('master.username', 'root'),
        'password'     => env('master.password', ''),
        'databaseName' => env('master.databaseName', 'test'),
        'databaseType' => env('master.databaseType', 'mysql'),
        'charset'      => env('master.charset', 'utf8mb4'),
        'collation'    => env('master.collation', 'utf8_unicode_ci'),
        'prefix'       => env('master.prefix', ''),
        'port'         => env('master.port', '3306')
    ],
    'slave'  => [
        'server'       => env('slave.server', '127.0.0.1'),
        'username'     => env('slave.username', 'root'),
        'password'     => env('slave.password', ''),
        'databaseName' => env('slave.databaseName', 'test'),
        'databaseType' => env('slave.databaseType', 'mysql'),
        'charset'      => env('slave.charset', 'utf8mb4'),
        'collation'    => env('slave.collation', 'utf8_unicode_ci'),
        'prefix'       => env('slave.prefix', ''),
        'port'         => env('slave.port', '3306')
    ],
];