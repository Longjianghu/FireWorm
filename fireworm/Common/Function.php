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
// 函数库
//----------------------------------

/**
 * 调试函数
 *
 * @access public
 * @param  mixed $data 打印数据
 * @return void
 */
if ( ! function_exists('dump')) {
    function dump($data)
    {
        echo '<pre>'.print_r($data).'</pre>';
    }
}

/**
 * 获取环境变量
 *
 * @access public
 * @param  string $item 选项
 * @param  mixed $default 默认值
 * @return string
 */
if ( ! function_exists('env')) {
    function env($item, $default = null)
    {
        $env = getenv($item);

        return ( ! empty($env)) ? $env : $default;
    }
}
