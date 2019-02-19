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
// 自定义异常接管
//----------------------------------

namespace FireWorm\Core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Fireworm\Exceptions\Exception;
use Fireworm\Exceptions\LogicException;

class ExceptionHandler
{
    /**
     * 接管程序
     *
     * @access public
     * @param \Throwable $e
     * @return mixed
     */
    public static function handle(\Throwable $e)
    {
        $error = [
            'code'  => $e->getCode(),
            'line'  => $e->getLine(),
            'file'  => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ];

        if ( ! $e instanceof Exception) {
            self::addLog($e->getMessage(), $error, ($e instanceof LogicException) ? true : false);
        }

        echo $e->getMessage();
    }

    /**
     * 添加日志
     *
     * @access public
     * @param  string $message 日志内容
     * @param  array  $content 日志内容
     * @param  string $debug   调试日志
     * @return void
     */
    public static function addLog(string $message, array $content = [], $debug = true)
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