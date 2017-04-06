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
        phpinfo();
    }

    public function article()
    {
    	//echox dfdfd;
        Session::set('user', ['uid' => 1000, 'name' => 'xiaohua']);
        print_r(Session::get());
        // $mem = new \Memcache();
        // $mem->connect('127.0.0.1', 11211);
        // //$mem->add('aaaa', "dffd");
        // echo $mem->get('aaaa');
    }

}
