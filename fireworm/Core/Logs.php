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

namespace Fireworm\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Logs
{
    /**
     * 添加DEBUG 日志
     *
     * @access public
     * @param  string $message 日志内容
     * @param  array  $content 日志内容
     * @param  bool   $debug   DEBUG日志
     * @return void
     */
    public static function addUserLog(string $message, array $content = [], bool $debug = true)
    {
        $logPath = RUN_PATH.'/logs/'.date('ymd');

        if ( ! is_dir($logPath)) {
            @mkdir($logPath, 0777, true);
        }

        $filename = sprintf('%s/%s.log', $logPath, ( ! empty($debug)) ? 'debug' : 'error');
        $level    = ( ! empty($debug)) ? LOGGER::DEBUG : Logger::ERROR;

        $Logger = (new Logger('log'))->pushHandler(new StreamHandler($filename, $level));
        ( ! empty($debug))? $Logger->addDebug($message, $content):$Logger->addError($message, $content);
    }
}