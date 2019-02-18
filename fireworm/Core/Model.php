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
// 模型层
//----------------------------------

namespace Fireworm\Core;

use Medoo\Medoo;
use Fireworm\Helpers\ArrayHelper;

class Model
{
    public $_db;

    public static $isLoad;

    /**
     * 初始化.
     *
     * @access public
     * @param  string $pool 连接池
     * @return void
     */
    public function __construct($pool = 'master')
    {
        if (isset(self::$isLoad[$pool])) {
            $this->_db = self::$isLoad[$pool];
        } else {
            $config = Config::item($pool, 'database');

            if (empty($config)) {
                throw new \Exception('数据库配置不存在！');
            }

            $this->_config = [
                'server'        => ArrayHelper::getValue($config, 'server'),
                'username'      => ArrayHelper::getValue($config, 'username'),
                'password'      => ArrayHelper::getValue($config, 'password'),
                'database_type' => ArrayHelper::getValue($config, 'databaseType'),
                'database_name' => ArrayHelper::getValue($config, 'databaseName'),
                'charset'       => ArrayHelper::getValue($config, 'charset'),
                'collation'     => ArrayHelper::getValue($config, 'collation'),
                'prefix'        => ArrayHelper::getValue($config, 'prefix'),
                'port'          => 3306,
            ];

            $this->_db = new Medoo($this->_config);

            self::$isLoad[$pool] = $this->_db;
        }
    }

    /**
     * 删除数据
     *
     * @access public
     * @link   https://medoo.in/api/update
     * @param  string $table 数据表
     * @param  array  $where 删除条件
     * @return int
     */
    public function delete(string $table, array $where)
    {
        return $this->_db->delete($table, $where)->rowCount();
    }

    /**
     * 获取数据对象
     *
     * @access public
     * @return object
     */
    public function fetchDb()
    {
        return $this->_db;
    }

    /**
     * 查询数据
     *
     * 查询字段支持string/array,字段排序和LIMIT格式示例：
     *
     * @example $where = ['ORDER' => ['id' => 'desc','LIMIT' => [0,2] / 10 ]
     *
     * @access  public
     * @link    https://medoo.in/api/select
     * @param  string $table   数据表
     * @param  mixed  $columns 查询字段
     * @param  array  $where   查询条件
     * @return mixed
     */
    public function fetchRow(string $table, $columns = '*', array $where = [])
    {
        $where['LIMIT'] = 1;

        $result = $this->_db->select($table, $columns, $where);

        return array_shift($result);
    }

    /**
     * 查询数据
     *
     * 查询字段支持string/array,字段排序和LIMIT格式示例：
     *
     * @example $where = ['ORDER' => ['id' => 'desc','LIMIT' => [0,2] / 10 ]
     *
     * @access  public
     * @link    https://medoo.in/api/select
     * @param  string $table   数据表
     * @param  mixed  $columns 查询字段
     * @param  array  $where   查询条件
     * @return mixed
     */
    public function fetchAll(string $table, $columns = '*', array $where = [])
    {
        return $this->_db->select($table, $columns, $where);
    }

    /**
     * 判断数据是否存在
     *
     * @access public
     * @link   https://medoo.in/api/has
     * @param  string $table 数据表
     * @param  array  $where 查询条件
     * @return bool
     */
    public function has(string $table, array $where)
    {
        return $this->_db->has($table, $where);
    }

    /**
     * 获取最近执行的SQL
     *
     * @access public
     * @return string
     */
    public function last()
    {
        return $this->_db->last();
    }

    /**
     * 写入数据
     *
     * @access public
     * @link   https://medoo.in/api/insert
     * @param  string $table 数据表
     * @param  array  $data  插入数据
     * @return int
     */
    public function insert(string $table, array $data)
    {
        $query = $this->_db->insert($table, $data);

        return (isset($data[0])) ? $query->rowCount() : $this->_db->id();
    }

    /**
     * 手动执行SQL
     *
     * @access public
     * @link   https://medoo.in/api/query
     * @param  string $sql  SQL语句
     * @param  array  $map  绑定参数
     * @param  int    $type 记录类型 0：所有 1：单行 2：单列
     * @return array
     */
    public function execute(string $sql, array $map, int $type = 0)
    {
        $query = $this->_db->query($sql, $map);

        switch ($type) {
            case 0:
                return $query->fetchAll();
                break;
            case 1:
                return $query->fetch();
                break;
            case 2:
                return $query->fetchColumn();
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * 更新数据
     *
     * @access public
     * @link   https://medoo.in/api/update
     * @param  string $table 数据表
     * @param  array  $data  更新数据
     * @param  array  $where 更新条件
     * @return int
     */
    public function update(string $table, array $data, array $where)
    {
        return $this->_db->update($table, $data, $where)->rowCount();
    }
}