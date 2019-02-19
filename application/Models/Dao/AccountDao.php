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
// 会员账户
//----------------------------------

namespace App\Models\Dao;

use Fireworm\Core\Model;

class AccountDao extends Model
{
    const TABLE = 'account';
    const POOL  = 'master';

    /**
     * 初始化.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct(self::POOL);
    }

    /**
     * 查找所有会员
     *
     * @access public
     * @return mixed
     */
    public function findAll()
    {
        return $this->fetchAll(self::TABLE);
    }
}