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
// 文件配置类
//----------------------------------

namespace FireWorm\Core;

class Config
{
    public static $config = [];

    /**
     * 获取配置选项
     *
     * @access public
     * @param  string $item     配置选项
     * @param  string $filename 配置文件名
     * @return mixed
     */
    public static function item($item = null, string $filename = 'settings')
    {
        $filename = ucfirst($filename);

        if (isset(self::$config[$filename])) {
            return ( ! empty($item) && isset(self::$config[$filename][$item])) ? self::$config[$filename][$item] : null;
        }

        $path = sprintf('%s/Config/%s.php', APP_PATH, $filename);

        if ( ! is_file($path)) {
            $path = sprintf('%s/Common/%s.php', CORE_PATH, $filename);
        }

        if (is_file($path)) {
            $config = include_once $path;

            self::$config[$filename] = $config;
        }

        return ( ! empty($item) && isset(self::$config[$filename][$item])) ? self::$config[$filename][$item] : null;
    }
}