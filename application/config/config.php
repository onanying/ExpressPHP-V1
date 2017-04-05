<?php

// 项目配置文件
return [

    // 应用调试模式
    'app_debug'              => true,

    // 自动加载配置文件
    'autoload_config'        => ['mysql', 'redis'],

    // 默认过滤方法
    'request_default_filter' => 'htmlspecialchars',

    // session配置
    'session'                => [

        // 保存类型: file | redis | memcached
        'save_handler'   => 'redis',

        // 保存路径: /tmp | tcp://127.0.0.1:8888?auth=pwd
        'save_path'      => 'tcp://114.119.4.6:6388?auth=Fitcom2015jiankangyun123456QWERTyuiop',

        // session有效期
        'gc_maxlifetime' => 7200,

    ],

];
