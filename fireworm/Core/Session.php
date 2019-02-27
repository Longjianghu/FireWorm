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
// 会话管理
//----------------------------------

namespace Fireworm\Core;

use \Josantonius\Session\Session as Jsession;

class Session
{
    private $_prefix = '';

    /**
     * 初始化.
     *
     * @access public
     * @throws \Fireworm\Exceptions\ErrorException
     */
    public function __construct()
    {
        $this->_prefix = Config::item('sessionPrefix');

        Jsession::init();
        Jsession::setPrefix($this->_prefix);
    }

    /**
     * 获取会话数据
     *
     * @access public
     * @param string $key
     * @param string $secondkey
     * @return mixed|null
     */
    public function get(string $key = '', string $secondkey = '')
    {
        return Jsession::get($key, $secondkey);
    }

    /**
     * 设置会话数据
     *
     * @access public
     * @param mixed $key   会话KEY(支持数组)
     * @param mixed $value 会话数据
     * @return bool
     */
    public function set($key, $value = false)
    {
        return Jsession::set($key, $value);
    }

    /**
     * 获取会话ID
     *
     * @access public
     * @return string
     */
    public function id()
    {
        return Jsession::id();
    }

    /**
     * 弹出会话数据并删除
     *
     * @access public
     * @param  string $key 会话KEY
     * @return mixed|null
     */
    public function flash($key)
    {
        return Jsession::pull($key);
    }

    /**
     * 销毁会话数据
     *
     * @access public
     * @param  string $key    会话KEY
     * @param  bool   $prefix 销毁部分数据
     * @return bool
     */
    public function destroy($key = '', $prefix = false)
    {
        return Jsession::destroy($key, $prefix);
    }
}