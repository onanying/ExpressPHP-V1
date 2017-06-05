<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace api\controller;

use api\model\Users;
use sys\Request;

class News
{

    public function __construct()
    {
        $this->users = new Users();
    }

    // 减积分
    public function minusCredits()
    {
        $uid = Request::get('uid');
        $number = Request::get('number');
        if (!ctype_digit($uid) || !ctype_digit($number)) {
            return ['errCode' => 1, 'errMsg' => '参数错误'];
        }
        $this->users->minusCreditsAuto($uid, $number);
        return ['errCode' => 0, 'errMsg' => 'ok'];
    }

    // 新增用户
    public function add()
    {
        $userName = Request::post('userName');
        $phone = Request::post('phone');
        $credits = Request::post('credits');
        if (empty($userName) || !ctype_digit($phone) || !ctype_digit($credits)) {
            return ['errCode' => 1, 'errMsg' => '参数错误'];
        }
        $insertId = $this->users->add($userName, $phone, $credits);
        //echo \sys\Pdo::getLastSql();
        return ['errCode' => 0, 'errMsg' => 'ok', 'uid' => $insertId];
    }

}
