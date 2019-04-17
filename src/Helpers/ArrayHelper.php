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
// 数组辅助函数库
//----------------------------------

namespace Src\Helpers;

class ArrayHelper
{
    /**
     * 根据过滤规则获取数据
     *
     * 规则示例：
     *
     * $array = ['A' => [1, 2], 'B' => ['C' => 1, 'D' => 2], 'E' => 1];
     *
     * ArrayHelper::filter($array, ['A', 'B.C']
     * ArrayHelper::filter($array, ['B', '!B.C']
     *
     * @access public
     * @param  array $array   原始数组
     * @param  array $filters 过滤规则
     * @return mixed|null
     */
    public static function filter($array, $filters)
    {
        $result = [];
        $vars   = [];

        foreach ($filters as $var) {
            $keys   = explode('.', $var);
            $global = self::getValue($keys, 0);
            $local  = self::getValue($keys, 1);

            if ($global[0] === '!') {
                $vars[] = [substr($global, 1), $local];
                continue;
            }

            if ( ! array_key_exists($global, $array)) {
                continue;
            }

            if (is_null($local)) {
                $result[$global] = $array[$global];
                continue;
            }

            if ( ! isset($array[$global][$local])) {
                continue;
            }

            if ( ! array_key_exists($global, $result)) {
                $result[$global] = [];
            }

            $result[$global][$local] = $array[$global][$local];
        }

        foreach ($vars as $v) {
            list($global, $local) = $v;

            if (array_key_exists($global, $result)) {
                unset($result[$global][$local]);
            }
        }

        return $result;
    }

    /**
     * 获取数据列
     *
     * @access public
     * @param  array $array   数组
     * @param  array $key     KEY
     * @param  bool  $keepKey 保留KEY
     * @return mixed|null
     */
    public static function getColumn($array, $name, $keepKey = true)
    {
        $result = [];

        foreach ($array as $k => $v) {
            if ( ! empty($keepKey)) {
                $result[$k] = self::getValue($v, $name);
            } else {
                $result[] = self::getValue($v, $name);
            }
        }

        return $result;
    }

    /**
     * 获取数组内容
     *
     * @access public
     * @param  array  $array   数组
     * @param  string $key     KEY
     * @param  null   $default 默认值
     * @return mixed|null
     */
    public static function getValue($array, string $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);

            foreach ($key as $keyPart) {
                $array = self::getValue($array, $keyPart);
            }

            $key = $lastKey;
        }

        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = self::getValue($array, substr($key, 0, $pos), $default);
            $key   = substr($key, $pos + 1);
        }

        if (is_object($array)) {
            return isset($array->$key) ? $array->$key : $default;
        } elseif (is_array($array)) {
            return (isset($array[$key]) || array_key_exists($key, $array)) ? $array[$key] : $default;
        }

        return $default;
    }

    /**
     * 索引数据
     *
     * @access public
     * @param  array  $array 数组
     * @param  mixed  $key   KEY
     * @param  string $group 数据分组
     * @return mixed|null
     */
    public static function index($array, $key, array $group = [])
    {
        $result = [];
        $group  = (array)$group;

        foreach ($array as $k => $v) {
            $lastArray = &$result;

            foreach ($group as $g) {
                $value = static::getValue($v, $g);

                if ( ! array_key_exists($value, $lastArray)) {
                    $lastArray[$value] = [];
                }

                $lastArray = &$lastArray[$value];
            }

            if (is_null($key)) {
                if ( ! empty($group)) {
                    $lastArray[] = $v;
                }
            } else {
                $value = static::getValue($v, $key);

                if ( ! is_null($value)) {
                    if (is_float($value)) {
                        $value = $value;
                    }

                    $lastArray[$value] = $v;
                }
            }

            unset($lastArray);
        }

        return $result;
    }

    /**
     * 判断KEY是否存在
     *
     * @access public
     * @param  array  $array         数组
     * @param  string $key           VALUE
     * @param  bool   $caseSensitive 区分大小写
     * @return mixed|null
     */
    public static function keyExists($array, $key, $caseSensitive = true)
    {
        if ( ! empty($caseSensitive)) {
            return isset($array[$key]) || array_key_exists($key, $array);
        }

        foreach (array_keys($array) as $k) {
            if (strcasecmp($key, $k) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * 组装新数组
     *
     * @access public
     * @param  array  $array 数组
     * @param  string $from  KEY
     * @param  string $to    VALUE
     * @param  string $group 数据分组
     * @return mixed|null
     */
    public static function map($array, string $from, string $to, $group = null)
    {
        $result = [];

        foreach ($array as $k => $v) {
            $key   = self::getValue($v, $from);
            $value = self::getValue($v, $to);

            if ( ! is_null($group)) {
                $result[self::getValue($v, $group)][$key] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * 设置数组内容
     *
     * ArrayHelper::setValue($array, 'key.in.0', ['arr' => 'val']);
     *
     * @access public
     * @param  array  $array 数组
     * @param  string $path  KEY
     * @param  mixed  $value 默认值
     * @return mixed|null
     */
    public static function setValue(&$array, $path, $value)
    {
        if ($path === null) {
            $array = $value;

            return;
        }

        $keys = is_array($path) ? $path : explode('.', $path);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if ( ! isset($array[$key])) {
                $array[$key] = [];
            }

            if ( ! is_array($array[$key])) {
                $array[$key] = [$array[$key]];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;
    }
}