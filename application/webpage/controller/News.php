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
        //return View::create()->fetch('webpage.view.news_article')->assign('name', 'xiaohua')->assign('sex', 'w');

        //return View::create('webpage.view.news_article', ['name' => 'xiaohua', 'sex' => 'w']);

        //return Json::create(['errcode' => 0, 'errmsg' => 'ok']);

        //return ['errcode' => 0, 'errmsg' => 'ok'];

        /*
        $data = [
            'uid'    => [1, 2, 3, 4, 5, 6],
        ];
        $stmt = Mysql::query('select * from member where uid in (:uid)', $data);
        var_dump($stmt->fetch());
        var_dump($stmt->fetchObject());
        var_dump($stmt->fetchAll());
         */

        /*
        Mysql::transaction(function () {
            $params = ['uid' => $uid, 'number' => $number];
            Mysql::execute('update `money` set number = number - :number where uid = :uid', $params);
            Mysql::execute('INSERT INTO `history`(`uid`, `number`) VALUES(:uid, :number)', $params);
        });
         */

        Mysql::beginTransaction();
        try {
            $params = ['uid' => 101, 'number' => 1];
            Mysql::execute('update `money` set number = number - :number where uid = :uid', $params);
            Mysql::execute('INSERT INTO `history`(`uid`, `number`) VALUES(:uid, :number)', $params);
            // 提交事务
            Mysql::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Mysql::rollBack();
        }

        echo 'ok';
    }

}
