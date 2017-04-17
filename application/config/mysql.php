<?php

// mysql 配置文件
return [

    // 服务器地址
    'hostname'    => '127.0.0.1',
    // 数据库连接端口
    'hostport'    => '3306',
    // 数据库用户名
    'username'    => 'root',
    // 数据库密码
    'password'    => '123456',
    // 数据库名
    'database'    => 'test',
    // 数据库编码默认采用utf8
    'charset'     => 'utf8',

    // 设置PDO属性: http://php.net/manual/zh/pdo.setattribute.php
    'attribute'   => [

        // 设置默认的提取模式: \PDO::FETCH_OBJ | \PDO::FETCH_ASSOC
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        // 转换 NULL 和空字符串（在所有驱动中都可用，不仅限于Oracle）
        \PDO::ATTR_ORACLE_NULLS       => \PDO::NULL_NATURAL,
        // 强制列名为指定的大小写
        \PDO::ATTR_CASE               => \PDO::CASE_NATURAL,

    ],

    // 强制列名为驼峰
    'case_camel'  => true,

    // 事务
    'transaction' => [

        // 回滚含有零影响行数的事务
        'rollback_zero_affected' => true,

    ],

];
