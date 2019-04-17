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
// 自定义日志
//----------------------------------

namespace Src\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Logs
{
    /**
     * 添加日志
     *
     * @access public
     * @param  string $message 日志内容
     * @param  array  $content 日志内容
     * @param  string $debug   调试日志
     * @return void
     */
    public static function create(string $message, array $content = [], $debug = true)
    {
        $logPath = RUN_PATH.'/logs/'.date('ymd');

        if ( ! is_dir($logPath)) {
            @mkdir($logPath, 0777, true);
        }

        $filename = sprintf('%s/%s.log', $logPath, ( ! empty($debug)) ? 'debug' : 'error');
        $level    = ( ! empty($debug)) ? LOGGER::DEBUG : LOGGER::ERROR;
        $action   = ( ! empty($debug)) ? 'addDebug' : 'addError';

        (new Logger('log'))->pushHandler(new StreamHandler($filename, $level))->$action($message, $content);
    }
}