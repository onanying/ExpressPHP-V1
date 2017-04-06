<?php

// 项目配置文件
return [

    // 应用调试模式
    'app_debug'              => true,

    // 自动加载配置文件
    'autoload_config'        => ['mysql', 'redis', 'memcache'],

    // 默认过滤方法: htmlspecialchars | strip_tags
    'request_default_filter' => 'htmlspecialchars',

    // session配置
    'session'                => [

        // 保存类型: files | redis | memcache
        'save_handler'   => 'files',

        // files保存路径: /tmp
        'files_save_path' => 'c:/tmp',

        // session有效期
        'gc_maxlifetime' => 7200,

    ],

];
