<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 16:20
 */

namespace app\controller;

class HomeController extends \core\bootstrap
{
    public function index()
    {
        $this->display('home/index');
    }
}