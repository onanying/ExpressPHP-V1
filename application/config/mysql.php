<?php

// mysql 配置文件
return [

    /**
     * 连接配置
     */

    // 服务器地址
    'hostname'          => '127.0.0.1',
    // 数据库连接端口
    'hostport'          => '3306',
    // 数据库用户名
    'username'          => 'root',
    // 数据库密码
    'password'          => '123456',
    // 数据库名
    'database'          => 'test',
    // 数据库编码默认采用utf8
    'charset'           => 'utf8',

    /**
     * 运行配置
     */

    // 默认的提取类型: array | object
    'default_fetch'     => 'object',

    // 强制转换列名: natural | camelcase | lower | upper
    'force_column_name' => 'camelcase',

    // 将 NULL 转换成空字符串
    'null_to_string'    => false,

    // 事务
    'transaction'       => [

        // 回滚含有零影响行数的事务
        'rollback_zero_affected' => true,

    ],

];
