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
// 分页
//----------------------------------

namespace Src\Core;

use JasonGrimes\Paginator as Jpaginator;

class Paginator
{
    /**
     * 创建页码
     *
     * @access public
     * @param  int $total   记录总数
     * @param  int $perPage 每页显示数量
     * @return Jpaginator
     */
    public static function create($total = 0, $perPage = 10)
    {
        $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

        $paginator = new Jpaginator($total, $perPage, $page, sprintf('%s?page=(:num)', pageUrl(true)));
        $paginator->setMaxPagesToShow(5);

        return View::render('common/pager.twig', ['paginator' => $paginator], true);
    }
}