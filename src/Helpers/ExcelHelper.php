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
// Excel读取和生成
//----------------------------------
namespace Src\Helpers;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Reader\ReaderFactory;
use src\Exceptions\Exception;

class ExcelHelper
{
    /**
     * 读取Excel文档
     *
     * @access public
     * @param  string $filename 文件名
     * @param  bool   $multi    多个工作表
     * @return array
     */
    public static function readExcel($filename, $multi = false)
    {
        $status = ['code' => 0, 'data' => [], 'msg' => ''];

        try {
            $data = [];

            if ( ! is_file($filename)) {
                throw new Exception('你指定的文件不存在！');
            }

            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            if ( ! in_array($extension, ['csv', 'xlsx'])) {
                throw new Exception('只能读取xlsx和csv文档！');
            }

            $reader = ReaderFactory::create(($extension == 'xlsx') ? Type::XLSX : Type::CSV);

            $reader->open($filename);

            foreach ($reader->getSheetIterator() as $key => $val) {
                foreach ($val->getRowIterator() as $k => $v) {
                    $data[$key][] = array_map('trim', $v);
                }
            }

            $reader->close();

            $status = ['code' => 200, 'data' => ( ! empty($multi)) ? $data : array_shift($data), 'msg' => ''];
        } catch (Exception $e) {
            $status['msg'] = $e->getMessage();
        }

        return $status;
    }

    /**
     * 生成Excel文档
     *
     * example：$data = [['A11'], ['A12']];
     *
     * @access public
     * @param  array  $data     导出数据
     * @param  string $filename 文件名
     * @param  string $path     保存路径
     * @return void
     */
    public static function writeExcel($data, $filename = null, $path = null)
    {
        try {
            if (empty($data)) {
                throw new Exception('导出数据不能为空！');
            }

            if ( ! is_array($data)) {
                throw new Exception('导出数据格式有误！');
            }

            $filename = ( ! empty($filename)) ? $filename : date('YmdHis');
            $filename = rtrim($filename, '.xlsx').'.xlsx';

            $writer = WriterFactory::create(Type::XLSX);

            if ( ! empty($path)) {

                if ( ! is_dir($path)) {
                    @mkdir($path, 0777, true);
                }

                $filename = sprintf('%s/%s', $path, $filename);
                $writer->openToFile($filename);
            } else {
                $writer->openToBrowser(urlencode($filename));
            }

            $writer->addRows($data);
            $writer->close();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }
}