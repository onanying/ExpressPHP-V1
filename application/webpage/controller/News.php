<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use sys\Request;
use sys\Session;

class News
{

    public function index()
    {
        print_r(Request::param());
    }

    public function article()
    {
        Session::set('user', ['uid' => 1000, 'name' => 'xiaohua']);
        print_r(Session::get());
    }

}
