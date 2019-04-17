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

namespace App\Models\Data;

use App\Models\Dao\AccountDao;

class AccountData
{
    /**
     * @var \App\Models\Dao\AccountDao
     */
    private $_accountDao;

    /**
     * 初始化.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_accountDao = new AccountDao();
    }

    /**
     * 获取会员列表
     *
     * @access public
     * @return mixed
     */
    public function getUserList()
    {
        return $this->_accountDao->findAll();
    }
}