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
// HTTP 辅助函数库
//----------------------------------

namespace Fireworm\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpHelper
{
    /**
     * GET 请求
     *
     * @access public
     * @param  string $url     URL
     * @param  array  $args    提交参数
     * @param  array  $headers HEAD信息
     * @return array
     * @throws
     */
    public static function get(string $url, array $args = [], array $headers = [])
    {
        $status = ['code' => 0, 'data' => [], 'msg' => ''];

        try {
            $options = ( ! empty($args)) ? ['query' => $args] : [];

            if ( ! empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = (new Client())->request('GET', $url, $options);

            $status = ['code' => 200, 'data' => $response->getBody()->getContents(), 'msg' => ''];
        } catch (RequestException $e) {
            $status['msg'] = $e->getMessage();
        }

        return $status;
    }

    /**
     * POST 请求
     *
     * @access public
     * @param  string $url     URL
     * @param  array  $args    提交参数
     * @param  array  $headers HEAD信息
     * @return array
     * @throws
     */
    public static function post(string $url, array $args = [], array $headers = [])
    {
        $status = ['code' => 0, 'data' => [], 'msg' => ''];

        try {
            $options = ( ! empty($args)) ? ['form_params' => $args] : [];

            if ( ! empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = (new Client())->request('POST', $url, $options);

            $status = ['code' => 200, 'data' => $response->getBody()->getContents(), 'msg' => ''];
        } catch (RequestException $e) {
            $status['msg'] = $e->getMessage();
        }

        return $status;
    }

    /**
     * 文件上传
     *
     * @access public
     * @param  string $url      URL
     * @param  string $filename 上传文件
     * @param  array  $headers  HEAD信息
     * @return array
     * @throws
     */
    public static function upload(string $url, string $filename, array $headers = [])
    {
        $status = ['code' => 0, 'data' => [], 'msg' => ''];

        try {
            if ( ! is_file($filename)) {
                throw new RequestException('上传文件不存在！');
            }

            $options = [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => file_get_contents($filename),
                        'filename' => basename($filename)
                    ]
                ]
            ];

            if ( ! empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = (new Client())->request('POST', $url, $options);
            $status   = ['code' => 200, 'data' => $response->getBody()->getContents(), 'msg' => ''];
        } catch (RequestException $e) {
            $status['msg'] = $e->getMessage();
        }

        return $status;
    }
}