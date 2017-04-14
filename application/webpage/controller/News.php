<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use app\model\Users;

class News
{

    public function __construct()
    {
        $this->usersModel = new Users();
    }

    public function index()
    {
        phpinfo();
    }

    public function article()
    {
        $uid    = 100;
        $number = 1;
        $data   = $this->usersModel->getInfo($uid);
        $data   = $this->usersModel->getInfoAll();
        //$this->usersModel->minusCreditsManual($uid, $number);

        //return View::create()->fetch('webpage.view.news_article')->assign('name', 'xiaohua')->assign('sex', 'w');
        //return View::create('webpage.view.news_article', ['name' => 'xiaohua', 'sex' => 'w']);
        //return Json::create(['errcode' => 0, 'errmsg' => 'ok']);

        return ['errCode' => 0, 'errMsg' => 'ok', 'data' => $data];
    }

}
