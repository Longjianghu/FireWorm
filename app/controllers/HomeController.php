<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 16:20
 */

namespace app\controller;

use core\libs\view;

class HomeController
{
    public function index()
    {
        echo view::render('home/Index', ['content' => 'Welcome']);
    }
}