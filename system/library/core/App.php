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
        $pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $route = Route::match($pathinfo);
        if (!$route) {
            self::show404();
        }
        // 保存路由变量
        $GLOBALS['route'] = $route['args'];
        // 控制器路由
        if (strpos($route['path'], '/')) {
            self::runController($route);
            return;
        }
        // 命名空间路由
        if (strpos($route['path'], '\\')) {
            self::runLibrary($route);
            return;
        }
        self::showError();
    }

    // 执行控制器
    private static function runController($route)
    {
        // 转换路径参数
        $route['path'] = Route::convertPath($route['path'], $GLOBALS['route']);
        // 实例化控制器
        $classPath = dirname($route['path']);
        $methodName = basename($route['path']);
        $classFull = '\\app\\controller\\' . str_ireplace('/', '\\', $classPath);
        $controller = new $classFull;
        // 执行控制器的方法
        $controller->$methodName();
    }

    // 执行类方法
    private static function runLibrary()
    {

    }

    // 展现404错误
    public static function show404()
    {
        echo 'ERROR: 404';
        exit;
    }

    // 展现错误
    public static function showError()
    {
        echo 'ERROR';
        exit;
    }

}
