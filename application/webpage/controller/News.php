<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use app\model\UsersModel;

class News
{

    public function __construct()
    {
        $this->UsersModel = new UsersModel();
    }

    public function index()
    {
        phpinfo();
    }

    public function article()
    {
        $uid    = 100;
        $number = 1;
        $data   = $this->UsersModel->getInfo($uid);
        $data   = $this->UsersModel->getInfoAll();
        //$this->UsersModel->minusCreditsManual($uid, $number);

        //return View::create()->fetch('webpage.view.news_article')->assign('name', 'xiaohua')->assign('sex', 'w');
        //return View::create('webpage.view.news_article', ['name' => 'xiaohua', 'sex' => 'w']);
        //return Json::create(['errcode' => 0, 'errmsg' => 'ok']);

        return ['errCode' => 0, 'errMsg' => 'ok', 'data' => $data];
    }

}
