<?php

// 主配置文件
return [

    'appPath'         => dirname(__DIR__),

    // 注册树配置
    'register'        => [

        // 路由配置
        'route' => [
            // 类路径
            'class'               => 'express\Route',
            // 控制器命名空间
            'controllerNamespace' => 'www\controller',
            // 默认变量规则
            'defaultPattern'      => '[\w-]+',
            // 变量规则
            'patterns'            => [
                'id' => '\d+',
            ],
            // 路由规则
            'rules'               => [
                ':controller/:action' => ':controller/:action',
            ],
        ],

    ],

];
