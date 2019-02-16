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
// 入口文件
//----------------------------------

declare(strict_types=1);

define('VERSION', '1.0.0');
define('ROOT_PATH', dirname(__DIR__));
define('CORE_PATH', ROOT_PATH.'/fireworm');
define('APP_PATH', ROOT_PATH.'/application');
define('RUN_PATH', ROOT_PATH.'/runtime');
define('APP_ENV', 'dev');

ini_set('date.timezone', 'Asia/Shanghai');
ini_set('display_errors', (APP_ENV == 'dev') ? 'On' : 'Off');

require_once ROOT_PATH.'/vendor/autoload.php';

\Fireworm\Bootstrap::run();