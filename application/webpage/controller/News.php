<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use app\model\Users;
use sys\response\Xml;

class News
{

    public function __construct()
    {
        $this->users = new Users();
    }

    public function index()
    {
        phpinfo();
    }

    public function article()
    {

        // return 'hello world';

        // $uid    = 100;
        // $number = 1;
        // $data   = $this->users->getInfo($uid);
        // $data   = $this->users->getInfoAll();
        // $this->users->minusCreditsManual($uid, $number);

        // return View::create()->fetch('webpage.view.news.article')->assign('name', 'xiaohua')->assign('sex', 'w');
        // return View::create('webpage.view.news.article', ['name' => 'xiaohua', 'sex' => 'w']);
        // $view = new View();
        // $view->fetch('webpage.view.news.article');
        // $view->assign('name', 'xiaohua');
        // $view->assign('sex', 'w');
        // return $view;

        // return Json::create(['errcode' => 0, 'errmsg' => 'ok']);

        // return ['errCode' => 0, 'errMsg' => 'ok', 'data' => $data];

        return Xml::create(['errCode' => 0, 'errMsg' => 'ok', 'data' => [['name' => 'xiaohua', 'sex' => 'w'], ['name' => 'xiaohua', 'sex' => 'w']]]);
    }

}
