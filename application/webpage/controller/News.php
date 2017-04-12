<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\webpage\controller;

use sys\Mysql;

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

        //return ['errcode' => 0, 'errmsg' => 'ok'];
        
        $data = [
            'uid'    => [1, 2, 3, 4, 5, 6],
        ];
        $stmt = Mysql::query('select * from member where uid in (:uid)', $data);
        var_dump($stmt->fetch());
        var_dump($stmt->fetchObject());
        var_dump($stmt->fetchAll());


    }

}
