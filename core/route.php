<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:45
 */

namespace core;

class route
{
    public $directory  = ''; // 控制器目录
    public $controller = 'home'; // 默认控制器
    public $method     = 'index'; // 默认方法

    public function __construct()
    {
        $this->_parseUri();
    }

    public function fetchFilename()
    {
        return sprintf('%s/%sController.php', $this->directory, ucfirst($this->controller));
    }

    public function fetchController()
    {
        return $this->controller;
    }

    public function fetchMethod()
    {
        return $this->method;
    }

    public function fetchDirectory()
    {
        return $this->directory;
    }

    private function _parseUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if ($uri != '/') {
            if (stripos($uri, 'index.php') !== false) {
                $uri = substr($uri, stripos($uri, 'index.php'));
            }

            $uri    = ltrim($uri, '/');
            $uriArr = explode('/', $uri);

            $path = '';

            foreach ($uriArr as $k => $v) {
                $path .= sprintf('/controller/%s', $v);

                if ( ! is_dir(APP_PATH.$path)) {
                    break;
                }

                unset($uriArr[$k]);
                $this->_setDirectory($path);
            }

            $this->_setController(array_shift($uriArr));
            $this->_setMethod(array_shift($uriArr));

            if (empty($this->controller)) {
                $this->_setController('home');
            }

            if (empty($this->method)) {
                $this->_setMethod('index');
            }

            if ( ! empty($uriArr)) {
                $i     = 0;
                $count = count($uriArr);

                do {
                    if ( ! isset($uriArr[$i + 1])) {
                        break;
                    }

                    $_GET[$uriArr[$i]] = $uriArr[$i + 1];

                    $i += 2;
                } while ($i < $count);
            }
        }
    }

    private function _setController($controller)
    {
        $this->controller = $controller;
    }

    private function _setMethod($method)
    {
        $this->method = $method;
    }

    private function _setDirectory($directory)
    {
        $this->directory = $directory;
    }
}