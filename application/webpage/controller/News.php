<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use sys\View;
use sys\Session;

class News
{

    public function index()
    {
        phpinfo();
    }

    public function article()
    {
        Session::get('name');

        // $view = new View();
        // $view->fetch('webpage.view.sample');
        // $view->assign('name', 'xiaohua');
        // $view->assign('sex', 'w');
        // return $view;

        //return view()->fetch('webpage.view.sample')->assign('name', 'xiaohua')->assign('sex', 'w');

        // return view('webpage.view.sample', ['name' => 'xiaohua', 'sex' => 'w']);
    }

}
