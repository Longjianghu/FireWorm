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
// 自定义环境变量
//----------------------------------

namespace Src\Core;

class DotEnv
{
    public $path; // 配置文件路径

    /**
     * 初始化.
     *
     * @access public
     * @param string $path 文件路径
     * @param string $file 文件名称
     * @return void
     */
    public function __construct(string $path, string $file = '.env')
    {
        $this->path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;
    }

    /**
     * 加载配置文件
     *
     * @access public
     * @return bool
     */
    public function load()
    {
        if ( ! is_file($this->path)) {
            return false;
        }

        if ( ! is_readable($this->path)) {
            throw new \InvalidArgumentException('The .env file is not readable: '.$this->path);
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                $this->setVariable($line);
            }
        }

        return true;
    }

    /**
     * 设置环境变量
     *
     * @access public
     * @param  string $name  变量名称
     * @param  string $value 变量值
     * @return void
     */
    protected function setVariable(string $name, string $value = '')
    {
        list($name, $value) = $this->normaliseVariable($name, $value);

        if ( ! getenv($name, true)) {
            putenv("$name=$value");
        }
        if (empty($_ENV[$name])) {
            $_ENV[$name] = $value;
        }
        if (empty($_SERVER[$name])) {
            $_SERVER[$name] = $value;
        }
    }

    /**
     * 分析赋值
     *
     * @access public
     * @param  string $name  变量名称
     * @param  string $value 变量值
     * @return array
     */
    public function normaliseVariable(string $name, string $value = ''): array
    {
        if (strpos($name, '=') !== false) {
            list($name, $value) = explode('=', $name, 2);
        }

        $name  = trim($name);
        $value = trim($value);

        $name = str_replace(['export', '\'', '"'], '', $name);

        $value = $this->sanitizeValue($value);
        $value = $this->resolveNestedVariables($value);

        return [$name, $value];
    }

    /**
     * 提取变量.
     *
     * @access public
     * @param  string $value 环境变量
     * @return string
     */
    protected function sanitizeValue(string $value): string
    {
        if ( ! $value) {
            return $value;
        }

        if (strpbrk($value[0], '"\'') !== false) {
            $quote        = $value[0];
            $regexPattern = sprintf('/^
					%1$s          # match a quote at the start of the value
					(             # capturing sub-pattern used
								  (?:          # we do not need to capture this
								   [^%1$s\\\\] # any character other than a quote or backslash
								   |\\\\\\\\   # or two backslashes together
								   |\\\\%1$s   # or an escaped quote e.g \"
								  )*           # as many characters that match the previous rules
					)             # end of the capturing sub-pattern
					%1$s          # and the closing quote
					.*$           # and discard any string after the closing quote
					/mx', $quote);
            $value        = preg_replace($regexPattern, '$1', $value);
            $value        = str_replace("\\$quote", $quote, $value);
            $value        = str_replace('\\\\', '\\', $value);
        } else {
            $parts = explode(' #', $value, 2);
            $value = trim($parts[0]);

            if (preg_match('/\s+/', $value) > 0) {
                throw new \InvalidArgumentException('.env values containing spaces must be surrounded by quotes.');
            }
        }

        return $value;
    }

    /**
     * 解析变量.
     *
     * @access public
     * @param string $value 变量名称
     * @return string
     */
    protected function resolveNestedVariables(string $value): string
    {
        if (strpos($value, '$') !== false) {
            $loader = $this;

            $value = preg_replace_callback('/\${([a-zA-Z0-9_]+)}/', function ($matchedPatterns) use ($loader) {
                $nestedVariable = $loader->getVariable($matchedPatterns[1]);

                if (is_null($nestedVariable)) {
                    return $matchedPatterns[0];
                }

                return $nestedVariable;
            }, $value);
        }

        return $value;
    }

    /**
     * 搜索变量
     *
     * @access public
     * @param  string $name 变量名称
     * @return string|null
     */
    protected function getVariable(string $name)
    {
        switch (true) {
            case array_key_exists($name, $_ENV):
                return $_ENV[$name];
                break;
            case array_key_exists($name, $_SERVER):
                return $_SERVER[$name];
                break;
            default:
                $value = getenv($name);

                return ( ! empty($value)) ? $value : null;
        }
    }
}