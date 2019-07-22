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
// 公共函数库
//----------------------------------

/**
 * 加解密函数
 *
 * @access public
 * @param string  $string 字符串
 * @param bool    $decode 数据解密
 * @param integer $expiry 有效期
 * @param string  $key    加密密钥
 * @return string
 */
if ( ! function_exists('authcode')) {
    function authcode(string $string, bool $decode = false, int $expiry = 0, string $key = '')
    {
        $str    = '';
        $length = 4;

        $key = ( ! empty($key)) ? $key : '';

        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $length ? (( ! empty($decode)) ? substr($string, 0, $length) : substr(md5(microtime()), -$length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $k_length = strlen($cryptkey);

        $string   = ( ! empty($decode)) ? base64_decode(substr($string, $length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $s_length = strlen($string);

        $box    = range(0, 255);
        $rndkey = [];

        for ($i = 0; $i <= 255; ++$i) {
            $rndkey[$i] = ord($cryptkey[$i % $k_length]);
        }

        for ($j = $i = 0; $i < 256; ++$i) {
            $j       = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp     = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $s_length; ++$i) {
            $a       = ($a + 1) % 256;
            $j       = ($j + $box[$a]) % 256;
            $tmp     = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;

            $str .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ( ! empty($decode)) {
            if ((substr($str, 0, 10) == 0 || substr($str, 0, 10) - time() > 0) && substr($str, 10, 16) == substr(md5(substr($str, 26).$keyb), 0, 16)) {
                $str = substr($str, 26);
            }
        } else {
            $str = $keyc.str_replace('=', '', base64_encode($str));
        }

        return $str;
    }
}

/**
 * 下划线转陀峰
 *
 * @access  public
 * @param mixed $covert 转换数据
 * @return  void
 */
if ( ! function_exists('convertHump')) {
    function convertHump($covert)
    {
        $data = [];

        if (is_array($covert) || is_object($covert)) {
            foreach ($covert as $key => $val) {
                if (stripos($key, '_') !== false) {
                    $key = explode('_', $key);

                    foreach ($key as $k => $v) {
                        $key[$k] = ucfirst(strtolower($v));
                    }

                    $key = implode('', $key);
                    $key = lcfirst($key);
                }

                $data[$key] = convertHump($val);
            }
        } else {
            $data = $covert;
        }

        return $data;
    }
}

/**
 * 获取环境变量
 *
 * @access public
 * @param string $item    选项
 * @param mixed  $default 默认值
 * @return string
 */
if ( ! function_exists('env')) {
    function env(string $item, $default = null)
    {
        $env = getenv($item);

        return ( ! empty($env)) ? $env : $default;
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

/**
 * 获取微秒
 *
 * @access public
 * @return string
 */
if ( ! function_exists('microtimeFloat')) {
    function microtimeFloat()
    {
        list($usec, $sec) = explode(' ', microtime());

        return ((float)$usec + (float)$sec);
    }
}

/**
 * 对象转数组
 *
 * @access public
 * @param object $var 操作对象
 * @return array
 */
if ( ! function_exists('obj2arr')) {
    function obj2arr($var)
    {
        $var = json_decode(json_encode($var), true);

        return (json_last_error() === JSON_ERROR_NONE) ? $var : null;
    }
}

/**
 * 页面地址
 *
 * @access public
 * @param bool $filter 是否过滤
 * @return string
 */
if ( ! function_exists('pageUrl')) {
    function pageUrl($filter = false)
    {
        $offset = stripos($_SERVER['REQUEST_URI'], '?');

        $url = [
            'port'  => '//',
            'host'  => $_SERVER['HTTP_HOST'],
            'uri'   => ($offset !== false) ? substr($_SERVER['REQUEST_URI'], 0, $offset) : $_SERVER['REQUEST_URI'],
            'query' => $_SERVER['QUERY_STRING'],
        ];

        if ( ! empty($url['query'])) {
            parse_str($url['query'], $param);

            if (isset($param['page']) && ! empty($filter)) {
                unset($param['page']);
            }

            $url['query'] = ( ! empty($param)) ? sprintf('?%s', http_build_query($param, '', '&')) : '';
        }

        $url = implode('', $url);

        return $url;
    }
}

/**
 * 随机字符串
 *
 * @access public
 * @param integer $len 字符长度
 * @param bool    $int 纯数字
 * @return string
 */
if ( ! function_exists('random')) {
    function random(int $len = 10, bool $num = false)
    {
        $str = '';
        $len = (is_numeric($len)) ? $len : 10;

        $seed = base_convert(md5(microtime(true).uniqid(mt_rand(), true)), 16, ( ! empty($num)) ? 10 : 35);
        $seed = ( ! empty($num)) ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));

        if (empty($num)) {
            $str = chr(mt_rand(1, 26) + mt_rand(0, 1) * 32 + 64);
            --$len;
        }

        $max = strlen($seed) - 1;

        for ($i = 0; $i < $len; ++$i) {
            $str .= $seed{mt_rand(0, $max)};
        }

        return $str;
    }
}

/**
 * 删除本地文件
 *
 * @access public
 * @param string $filename 本地文件
 * @return bool
 */
if ( ! function_exists('remove')) {
    function remove(string $filename)
    {
        return (is_file($filename)) ? @unlink($filename) : true;
    }
}

/**
 * 删除目录
 *
 * @access public
 * @param string $path   目录路径
 * @param bool   $delDir 删除根目录
 * @return bool
 */
if ( ! function_exists('rmdir')) {
    function rmdir(string $path, bool $delDir = true)
    {
        $path = trim($path, '/\\');

        if ( ! $currentDir = @opendir($path)) {
            return false;
        }

        while (false !== ($filename = @readdir($currentDir))) {
            if ($filename !== '.' && $filename !== '..') {
                $filepath = $path.DIRECTORY_SEPARATOR.$filename;

                if (is_dir($filepath)) {
                    rmdir($filepath, $delDir);
                } else {
                    @unlink($filepath);
                }
            }
        }

        closedir($currentDir);

        return ($delDir === true) ? @rmdir($path) : true;
    }
}

/**
 * 交易编号
 *
 * @access public
 * @param string $prefix 前缀
 * @param int    $length 编号长度
 * @return string
 */
if ( ! function_exists('tradeNo')) {
    function tradeNo(string $prefix = '', int $length = 20)
    {
        $str = sprintf('%s%s', $prefix, ($length > 10) ? date('ymdhis') : random(round($length / 2), true));
        $str = sprintf('%s%s', $str, random($length - strlen($str)));

        return strtoupper($str);
    }
}

/**
 * 调试函数
 *
 * @access public
 * @param mixed $data   打印数据
 * @param bool  $format 格式化打印
 * @param bool  $break  是否中断
 * @return void
 */
if ( ! function_exists('dd')) {
    function dd($data, $format = false, $break = true)
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
 * 文件上传
 *
 * @access public
 * @param string $field     上传字段
 * @param string $path      上传路径
 * @param string $allowType 文件类型
 * @return array
 */
if ( ! function_exists('upload')) {
    function upload(string $field, string $path = 'upload', string $allowType = '*')
    {
        $status = ['code' => 0, 'data' => '', 'msg' => ''];

        try {
            $upload = (isset($_FILES[$field])) ? $_FILES[$field] : '';

            if ( ! isset($upload['error']) || $upload['error'] != 0) {
                throw new Exception('请选择上传文件！');
            }

            $info      = pathinfo($upload['name']);
            $allowType = explode(',', $allowType);

            if ($allowType != '*' && ! in_array($info['extension'], $allowType)) {
                throw new Exception('不允许上传的文件格式！');
            }

            $path = ( ! empty($path)) ? $path : '';
            $path = rtrim($path, '/');

            if ( ! is_dir($path)) {
                @mkdir($path, 0777, true);
            }

            if ( ! is_writable($path)) {
                throw new Exception('上传目录没有写入权限！');
            }

            $filename = sprintf('%s/%s.%s', $path, random(20), $info['extension']);

            if ( ! is_uploaded_file($upload['tmp_name'])) {
                throw new Exception('请重新上传文件！');
            }

            $query = move_uploaded_file($upload['tmp_name'], $filename);

            if (empty($query)) {
                throw new Exception('文件上传失败！');
            }

            $status = ['code' => 200, 'data' => $filename, 'msg' => ''];
        } catch (Exception $e) {
            $status['msg'] = $e->getMessage();
        }

        return $status;
    }
}

/**
 * 输出JSON数据
 *
 * @access  public
 * @param mixed $response 输出数据
 * @return  void
 */
if ( ! function_exists('withJSON')) {
    function withJSON($response)
    {
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type:application/json;charset=utf8');

        $response['data'] = ( ! empty($response['data'])) ? convertHump($response['data']) : new \stdClass();

        exit(json_encode($response));
    }
}