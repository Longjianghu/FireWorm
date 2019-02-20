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
        $data = [
            'code'    => $e->getCode(),
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
            'trace'   => json_encode($e->getTrace()),
        ];

        if ( ! $e instanceof Exception) {
            \Fireworm\Core\Logs::create($e->getMessage(), $data, ($e instanceof LogicException) ? true : false);
        }

        \Fireworm\Core\View::render('errors/index', $data);
    }
}