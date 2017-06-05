<?php

// 主配置文件
return [

    // 应用调试模式
    'app_debug'       => true,

    // 自动加载配置文件
    'autoload_config' => ['pdo', 'redis', 'memcache'],

    // request配置
    'request'         => [

        // 默认过滤方法: htmlspecialchars | strip_tags | 空字符
        'default_filter' => 'htmlspecialchars',

    ],

    // response配置
    'response'        => [

        // 数组默认转换类型: json | jsonp | xml
        'array_default_convert' => 'json',

    ],

    // json配置
    'json'            => [

        // jsonp 回调函数名
        'jsonp_callback' => 'callback',

        // 将 NULL 转换成空字符串
        'null_to_string' => false,

    ],

    // session配置
    'session'         => [

        // session名称
        'name'            => 'PHPSESSID',

        // 保存类型: files | redis | memcache
        'save_handler'    => 'files',

        // files保存路径: /tmp
        'files_save_path' => 'c:/tmp',

        // session有效期
        'gc_maxlifetime'  => 7200,

    ],

    // cookie配置
    'cookie'          => [

        // 过期时间
        'expire'        => 0,

        // 有效的服务器路径
        'path'          => '/',

        // 有效域名/子域名
        'domain'        => '',

        // 仅通过安全的 HTTPS 连接传给客户端
        'secure'        => false,

        // 仅可通过 HTTP 协议访问
        'httponly'      => false,

        // 签名密钥
        'signature_key' => '',

    ],

    // http错误
    'http_exception'  => [

        // 自定义404错误: 视图地址 | 数组 | 空字符
        // 视图地址: 404 => 'view.404',
        // 数组: 404 => ['errCode'=>-1, 'errMsg'=>'404 Not Found'],
        404 => ['errCode' => -1, 'errMsg' => '404 Not Found'],

    ],

];
