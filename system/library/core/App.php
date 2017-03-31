<?php

/**
 * App类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class App
{

    // 运行
    public static function run()
    {
        $pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        $fullPath = Route::match($pathinfo);
        if (!$fullPath) {
            self::show404();
        }
        self::runController($fullPath);
    }

    // 执行控制器
    private static function runController($fullPath)
    {


        print_r($GLOBALS['route']);
        print_r($fullPath);die;


        // 实例化控制器
        $classPath = dirname($fullPath);
        $methodName = basename($fullPath);
        $namespace = '\\app\\' . str_ireplace('/', '\\', $classPath);
        $controller = new $namespace;
        // 执行控制器的方法
        $controller->$methodName();
    }

    // 输出404错误
    public static function show404()
    {
        echo 'ERROR: 404';
        exit;
    }

    // 输出错误
    public static function showError()
    {
        echo 'ERROR';
        exit;
    }

}
