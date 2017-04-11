<?php

// 数据库配置文件
return [

    /**
     * 连接配置
     */

    // 数据库连接DSN配置
    'dsn'              => '',
    // 服务器地址
    'hostname'         => '127.0.0.1',
    // 数据库连接端口
    'hostport'         => '3306',
    // 数据库用户名
    'username'         => 'root',
    // 数据库密码
    'password'         => '123456',
    // 数据库名
    'database'         => 'test',
    // 数据库编码默认采用utf8
    'charset'          => 'utf8',
    // 数据库表前缀
    'prefix'           => 'think_',

    /**
     * 运行配置
     */

    // 默认的提取模式: array | object
    'default_fetch'    => 'array',

    // 将 NULL 转换成空字符串
    'null_to_string'   => false,

    // 列名模式: natural | camelcase | lower | upper
    'column_name_mode' => 'camelcase',

];
