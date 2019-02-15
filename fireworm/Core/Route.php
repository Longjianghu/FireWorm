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
// 路由文件
//----------------------------------

namespace FireWorm\Core;

class Route
{
    private $_nameSpace      = ''; // 命名空间
    private $_controller     = ''; // 默认控制器
    private $_method         = ''; // 默认方法
    private $_controllerPath = ''; // 控制器目录

    /**
     * 初始化
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_controller     = Config::item('defaultController');
        $this->_method         = Config::item('defaultMethod');
        $this->_controllerPath = Config::item('controllerPath');

        $this->_parseUri();
    }

    /**
     * 获取控制器
     *
     * @access public
     * @return string
     */
    public function fetchController()
    {
        return ucfirst(sprintf('%sController', $this->_controller));
    }

    /**
     * 获取方法名称
     *
     * @access public
     * @return string
     */
    public function fetchMethod()
    {
        return $this->_method;
    }

    /**
     * 获取命名空间
     *
     * @access public
     * @return string
     */
    public function fetchNameSpace()
    {
        $this->_nameSpace = str_replace('/', '\\', $this->_nameSpace);

        if (stripos($this->_nameSpace, '\\') !== false) {
            $this->_nameSpace = explode('\\', $this->_nameSpace);

            foreach ($this->_nameSpace as $k => $v) {
                $this->_nameSpace[$k] = ucfirst($v);
            }

            $this->_nameSpace = implode('\\', $this->_nameSpace);
        } else {
            $this->_nameSpace = ucfirst($this->_nameSpace);
        }

        return sprintf('App\Controllers\%s', $this->_nameSpace);
    }

    /**
     * 解析URI
     *
     * @access private
     * @return void
     */
    private function _parseUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri != '/') {
            if (stripos($uri, 'index.php') !== false) {
                $uri = substr($uri, stripos($uri, 'index.php') + 9);
            }

            $uri     = ltrim($uri, '/');
            $segment = explode('/', $uri);

            $path = $this->_controllerPath;

            foreach ($segment as $k => $v) {
                $path .= sprintf('/%s', strtolower($v));

                if ( ! is_dir(APP_PATH.'/'.$path)) {
                    break;
                }

                unset($segment[$k]);
                $this->_setNameSpace(sprintf('/%s', trim($path, '/')));
            }

            if ( ! empty($segment)) {
                $this->_setController(array_shift($segment));
            }

            if ( ! empty($segment)) {
                $this->_setMethod(array_shift($segment));
            }

            if (empty($this->_controller)) {
                $this->_setController(Config::item('defaultController'));
            }

            if (empty($this->_method)) {
                $this->_setMethod(Config::item('defaultMethod'));
            }

            if ( ! empty($segment)) {
                $i     = 0;
                $count = count($segment);

                do {
                    if ( ! isset($segment[$i + 1])) {
                        break;
                    }

                    $_GET[$segment[$i]] = $segment[$i + 1];

                    $i += 2;
                } while ($i < $count);
            }
        }
    }

    /**
     * 设置控制器
     *
     * @access private
     * @param  string $controller 控制器名称
     * @return void
     */
    private function _setController(string $controller)
    {
        $this->_controller = $controller;
    }

    /**
     * 设置方法名称
     *
     * @access private
     * @param  string $method 方法名称
     * @return void
     */
    private function _setMethod(string $method)
    {
        $this->_method = $method;
    }

    /**
     * 设置命名空间
     *
     * @access private
     * @param  string $nameSpace 命名空间
     * @return void
     */
    private function _setNameSpace(string $nameSpace)
    {
        $this->_nameSpace = str_replace('/'.$this->_controllerPath.'/', '', $nameSpace);
    }
}