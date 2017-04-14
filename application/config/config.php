<?php

// 主配置文件
return [

    // 应用调试模式
    'app_debug' => true,

    // 自动加载配置文件
    'autoload_config' => ['mysql', 'redis', 'memcache'],

    // request配置
    'request' => [

        // 默认过滤方法: htmlspecialchars | strip_tags | 空字符
        'default_filter' => 'htmlspecialchars',

    ],

    // response配置
    'response' => [

        // 数组默认转换类型: json | jsonp | xml
        'array_default_convert' => 'json',

    ],

    // json配置
    'json' => [

        // jsonp 回调函数名
        'jsonp_callback' => 'callback',

        // 将 NULL 转换成空字符串
        'null_to_string' => false,

    ],

    // session配置
    'session' => [

        // 保存类型: files | redis | memcache
        'save_handler' => 'redis',

        // files保存路径: /tmp
        'files_save_path' => 'c:/tmp',

        // session有效期
        'gc_maxlifetime' => 7200,

    ],

    // http错误
    'http_exception' => [

        // 自定义404错误: 视图地址 | 数组 | 空字符
        // 视图地址: 404 => 'error.404',
        // 数组: 404 => ['errcode'=>-1, 'errmsg'=>'404 Not Found'],
        404 => '',

    ],

];
