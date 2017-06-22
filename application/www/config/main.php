<?php

// 主配置文件
return [

    'basePath'  => dirname(__DIR__) . DS,

    // 注册树配置
    'register' => [

        // 配置
        'config' => [
            // 类路径
            'class'    => 'express\Config',
            // 自动加载
            'autoload' => ['common'],
        ],

        // 路由
        'route'  => [
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
