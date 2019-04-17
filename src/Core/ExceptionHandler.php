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

namespace Src\Core;

use src\Exceptions\Exception;
use src\Exceptions\LogicException;

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
            \Src\Core\Logs::create($e->getMessage(), $data, ($e instanceof LogicException) ? true : false);
        }

        \Src\Core\View::render('errors/index', $data);
    }
}