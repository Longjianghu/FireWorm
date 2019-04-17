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
// 自定义请求
//----------------------------------

namespace Src\Core;

use src\Helpers\ArrayHelper;
use voku\helper\AntiXSS;

class Request
{
    private $_antiXss;
    private $_cookie;
    private $_get;
    private $_files;
    private $_post;
    private $_server;

    /**
     * 初始化.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_antiXss = new AntiXSS();

        $this->_cookie = $this->_filter($_COOKIE);
        $this->_files  = $this->_filter($_FILES);
        $this->_get    = $this->_filter($_GET);
        $this->_post   = $this->_filter($_POST);
        $this->_server = $this->_filter($_SERVER);
    }

    /**
     * COOKIE
     *
     * @access public
     * @param  string $index   索引选项
     * @param  mixed  $default 默认值
     * @param  bool   $clean   是否过滤
     * @return mixed
     */
    public function cookie($index = null, $default = null, $clean = true)
    {
        $data = ( ! empty($index)) ? ArrayHelper::getValue($this->_cookie, $index, $default) : $this->_cookie;

        if ( ! empty($data)) {
            return ( ! empty($clean)) ? $this->_clean($data) : $data;
        }

        return $default;
    }

    /**
     * 上传文件
     *
     * @access public
     * @param  string $index   索引选项
     * @param  mixed  $default 默认值
     * @param  bool   $clean   是否过滤
     * @return mixed
     */
    public function files($index = null, $default = null, $clean = true)
    {
        $data = ( ! empty($index)) ? ArrayHelper::getValue($this->_files, $index, $default) : $this->_files;

        if ( ! empty($data)) {
            return ( ! empty($clean)) ? $this->_clean($data) : $data;
        }

        return $default;
    }

    /**
     * GET
     *
     * @access public
     * @param  string $index   索引选项
     * @param  mixed  $default 默认值
     * @param  bool   $clean   是否过滤
     * @return mixed
     */
    public function get($index = null, $default = null, $clean = true)
    {
        $data = ( ! empty($index)) ? ArrayHelper::getValue($this->_get, $index, $default) : $this->_get;

        if ( ! empty($data)) {
            return ( ! empty($clean)) ? $this->_clean($data) : $data;
        }

        return $default;
    }

    /**
     * GET / POST
     *
     * @access public
     * @param  string $index   索引选项
     * @param  mixed  $default 默认值
     * @param  bool   $clean   是否过滤
     * @return mixed
     */
    public function getPost($index = null, $default = null, $clean = true)
    {
        $data = $this->get($index, $default, $clean);

        return ( ! empty($data)) ? $data : $this->post($index, $default, $clean);
    }

    /**
     * 是否AJAX请求
     *
     * @access public
     * @return mixed
     */
    public function isAjax()
    {
        return (ArrayHelper::getValue($this->_server, 'HTTP_X_REQUESTED_WITH') == 'xmlhttprequest') ? true : false;
    }

    /**
     * POST
     *
     * @access public
     * @param  string $index   索引选项
     * @param  mixed  $default 默认值
     * @param  bool   $clean   是否过滤
     * @return mixed
     */
    public function post($index = null, $default = null, $clean = true)
    {
        $data = ( ! empty($index)) ? ArrayHelper::getValue($this->_post, $index, $default) : $this->_post;

        if ( ! empty($data)) {
            return ( ! empty($clean)) ? $this->_clean($data) : $data;
        }

        return $default;
    }

    /**
     * $_SERVER
     *
     * @access public
     * @param  string $index   索引选项
     * @param  mixed  $default 默认值
     * @param  bool   $clean   是否过滤
     * @return mixed
     */
    public function server($index = null, $default = null, $clean = true)
    {
        $data = ( ! empty($index)) ? ArrayHelper::getValue($this->_server, $index, $default) : $this->_server;

        if ( ! empty($data)) {
            return ( ! empty($clean)) ? $this->_clean($data) : $data;
        }

        return $default;
    }

    /**
     * XSS 过滤
     *
     * @access privae
     * @param  mixed $data 过滤数据
     * @return mixed
     */
    private function _clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = $this->_clean($v);
            }

            return $data;
        } else {
            return $this->_antiXss->xss_clean($data);
        }
    }

    /**
     * 数据过滤
     *
     * @access privae
     * @param  mixed $data 过滤数据
     * @return mixed
     */
    private function _filter($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = $this->_filter($v);
            }

            return $data;
        } else {
            $character = [
                '０' => '0',
                '１' => '1',
                '２' => '2',
                '３' => '3',
                '４' => '4',
                '５' => '5',
                '６' => '6',
                '７' => '7',
                '８' => '8',
                '９' => '9',
                'Ａ' => 'A',
                'Ｂ' => 'B',
                'Ｃ' => 'C',
                'Ｄ' => 'D',
                'Ｅ' => 'E',
                'Ｆ' => 'F',
                'Ｇ' => 'G',
                'Ｈ' => 'H',
                'Ｉ' => 'I',
                'Ｊ' => 'J',
                'Ｋ' => 'K',
                'Ｌ' => 'L',
                'Ｍ' => 'M',
                'Ｎ' => 'N',
                'Ｏ' => 'O',
                'Ｐ' => 'P',
                'Ｑ' => 'Q',
                'Ｒ' => 'R',
                'Ｓ' => 'S',
                'Ｔ' => 'T',
                'Ｕ' => 'U',
                'Ｖ' => 'V',
                'Ｗ' => 'W',
                'Ｘ' => 'X',
                'Ｙ' => 'Y',
                'Ｚ' => 'Z',
                'ａ' => 'a',
                'ｂ' => 'b',
                'ｃ' => 'c',
                'ｄ' => 'd',
                'ｅ' => 'e',
                'ｆ' => 'f',
                'ｇ' => 'g',
                'ｈ' => 'h',
                'ｉ' => 'i',
                'ｊ' => 'j',
                'ｋ' => 'k',
                'ｌ' => 'l',
                'ｍ' => 'm',
                'ｎ' => 'n',
                'ｏ' => 'o',
                'ｐ' => 'p',
                'ｑ' => 'q',
                'ｒ' => 'r',
                'ｓ' => 's',
                'ｔ' => 't',
                'ｕ' => 'u',
                'ｖ' => 'v',
                'ｗ' => 'w',
                'ｘ' => 'x',
                'ｙ' => 'y',
                'ｚ' => 'z',
                '（' => '(',
                '）' => ')',
                '〔' => '[',
                '〕' => ']',
                '【' => '[',
                '】' => ']',
                '〖' => '[',
                '〗' => ']',
                '｛' => '{',
                '｝' => '}',
                '《' => '<',
                '》' => '>',
                '％' => '%',
                '＋' => '+',
                '—' => '-',
                '－' => '-',
                '～' => '~',
                '？' => '?',
                '｜' => '|',
                '〃' => '"',
            ];

            $data = strtr($data, $character);

            return trim($data);
        }
    }
}