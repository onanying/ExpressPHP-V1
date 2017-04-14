<?php

/**
 * 模型
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\model;

use sys\Mysql;

class Users
{

	// 获取所有用户信息
    public function getInfoAll()
    {
        $stmt = Mysql::query(
            'SELECT * FROM `users`'
        );
        return $stmt->fetchAll();
    }

    // 获取用户信息
    public function getInfo($uid)
    {
        $stmt = Mysql::query(
            'SELECT * FROM `users` WHERE uid = :uid',
            [
                'uid' => $uid,
            ]
        );
        return $stmt->fetchObject();
    }

    // 减少积分 (手动事务)
    public function minusCreditsManual($uid, $number)
    {
        Mysql::beginTransaction();
        try {
            Mysql::execute(
                'update `money` set number = number - :number where uid = :uid',
                [
                    'uid'    => $uid,
                    'number' => $number,
                ]
            );
            Mysql::execute(
                'INSERT INTO `history`(`uid`, `number`) VALUES(:uid, :number)',
                [
                    'uid'    => $uid,
                    'number' => -$number,
                ]
            );
            // 提交事务
            Mysql::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Mysql::rollBack();
        }
    }

    // 减少积分 (自动事务)
    public function minusCreditsAuto($uid, $number)
    {
        Mysql::transaction(function () {
            Mysql::execute(
                'update `money` set number = number - :number where uid = :uid',
                [
                    'uid'    => $uid,
                    'number' => $number,
                ]
            );
            Mysql::execute(
                'INSERT INTO `history`(`uid`, `number`) VALUES(:uid, :number)',
                [
                    'uid'    => $uid,
                    'number' => -$number,
                ]
            );
        });
    }

}
