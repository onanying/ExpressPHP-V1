<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use sys\response\Json;
use sys\response\View;

class News
{

    public function index()
    {
        phpinfo();
    }

    public function article()
    {
        //return View::create()->fetch('webpage.view.new_article')->assign('name', 'xiaohua')->assign('sex', 'w');

        //return View::create('webpage.view.new_article', ['name' => 'xiaohua', 'sex' => 'w']);

        //return Json::create(['errcode' => 0, 'errmsg' => 'ok']);

        return ['errcode' => 0, 'errmsg' => 'ok'];
    }

}
