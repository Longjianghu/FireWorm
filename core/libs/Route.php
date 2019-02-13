<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:45
 */

namespace core\libs;

class Route
{
    private $_directory     = ''; // 控制器目录
    private $_controller    = ''; // 默认控制器
    private $_method        = ''; // 默认方法
    private $_controllerDir = ''; // 控制器目录

    public function __construct()
    {
        $this->_controller    = config::item('defaultController');
        $this->_method        = config::item('defaultMethod');
        $this->_controllerDir = config::item('controllerDir');

        $this->_parseUri();
    }

    public function filename()
    {
        $filename = $this->_controllerDir;

        if ( ! empty($this->_directory)) {
            $filename .= '/'.$this->_directory;
        }

        $filename .= sprintf('/%s.php', $this->fetchController());

        return ltrim($filename, '/');
    }

    public function fetchController()
    {
        return ucfirst(sprintf('%sController', $this->_controller));
    }

    public function fetchMethod()
    {
        return $this->_method;
    }

    public function fetchDirectory()
    {
        return $this->_directory;
    }

    private function _parseUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri != '/') {
            if (stripos($uri, 'index.php') !== false) {
                $uri = substr($uri, stripos($uri, 'index.php'));
            }

            $uri     = ltrim($uri, '/');
            $segment = explode('/', $uri);

            $path = $this->_controllerDir;

            foreach ($segment as $k => $v) {
                $path .= sprintf('/%s', strtolower($v));

                if ( ! is_dir(APP_PATH.'/'.$path)) {
                    break;
                }

                unset($segment[$k]);
                $this->_setDirectory(sprintf('/%s', trim($path, '/')));
            }

            if ( ! empty($segment)) {
                $this->_setController(array_shift($segment));
            }

            if ( ! empty($segment)) {
                $this->_setMethod(array_shift($segment));
            }

            if (empty($this->_controller)) {
                $this->_setController(config::item('defaultController'));
            }

            if (empty($this->_method)) {
                $this->_setMethod(config::item('defaultMethod'));
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

    private function _setController(string $controller)
    {
        $this->_controller = $controller;
    }

    private function _setMethod(string $method)
    {
        $this->_method = $method;
    }

    private function _setDirectory(string $directory)
    {
        $this->_directory = str_replace('/'.$this->_controllerDir.'/', '', $directory);
    }
}