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
// 函数库
//----------------------------------

/**
 * 调试函数
 *
 * @access public
 * @param  mixed $data   打印数据
 * @param  bool  $format 格式化打印
 * @param  bool  $break  是否中断
 * @return void
 */
if ( ! function_exists('p')) {
    function p($data, $format = false, $break = true)
    {
        if ( ! empty($format)) {
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
        } else {
            var_dump($data);
        }

        if ( ! empty($break)) {
            exit();
        }
    }
}

/**
 * 获取环境变量
 *
 * @access public
 * @param  string $item    选项
 * @param  mixed  $default 默认值
 * @return string
 */
if ( ! function_exists('env')) {
    function env($item, $default = null)
    {
        $env = getenv($item);

        return ( ! empty($env)) ? $env : $default;
    }
}

/**
 * 命令行
 *
 * @access public
 * @return string
 */
if ( ! function_exists('isCli')) {
    function isCli()
    {
        return PHP_SAPI === 'cli';
    }
}

/**
 * IP 地址
 *
 * @access public
 * @return string
 */
if ( ! function_exists('ipAddress')) {
    function ipAddress()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if ( ! preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }

        return $ip;
    }
}