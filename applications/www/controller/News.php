<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace www\controller;

use sys\response\View;
use www\model\Users;

class News
{

    public function __construct()
    {
        $this->users = new Users();
    }

    public function index()
    {
        echo '\www\controller\News->index';
    }

    public function forum()
    {
        return View::create('view.news.article', ['name' => 'xiaohua', 'sex' => 'w']);
    }

    public function article()
    {

        // return 'hello world';

        // $uid    = 100;
        // $number = 1;
        // $data   = $this->users->getInfo($uid);
        $data = $this->users->getInfoAll();
        print_r($data);

        // $this->users->minusCreditsManual($uid, $number);

        // return View::create()->fetch('webpage.view.news.article')->assign('name', 'xiaohua')->assign('sex', 'w');
        // return View::create('webpage.view.news.article', ['name' => 'xiaohua', 'sex' => 'w']);
        // $view = new View();
        // $view->fetch('webpage.view.news.article');
        // $view->assign('name', 'xiaohua');
        // $view->assign('sex', 'w');
        // return $view;

        // return Json::create(['errcode' => 0, 'errmsg' => 'ok']);

        //return ['errCode' => 0, 'errMsg' => 'ok', 'data' => [['name' => 'xiaohua', 'sex' => 'w'], ['name' => 'xiaohua', 'sex' => 'w']]];

        //return Xml::create(['errCode' => 0, 'errMsg' => 'ok', 'data' => [['name' => 'xiaohua', 'sex' => 'w'], ['name' => 'xiaohua', 'sex' => 'w']]]);
    }

}
