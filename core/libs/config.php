<?php
/**
 * Created by PhpStorm.
 * User: longjianghu
 * Date: 2019/2/12
 * Time: 22:32
 */

namespace core\libs;

class config
{
    public static $config = [];

    public static function load($item = null, $filename = 'settings')
    {
        if (isset(self::$config[$filename])) {
            return ( ! empty($item) && isset(self::$config[$filename][$item])) ? self::$config[$filename][$item] : null;
        }

        $path = sprintf('%s/config/%s.php', APP_PATH, $filename);

        if ( ! is_file($path)) {
            $path = sprintf('%s/common/%s.php', CORE_PATH, $filename);
        }

        if (is_file($path)) {
            $config = include_once $path;

            self::$config[$filename] = $config;
        }

        return ( ! empty($item) && isset(self::$config[$filename][$item])) ? self::$config[$filename][$item] : null;
    }
}