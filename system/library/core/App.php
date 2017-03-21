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
        $routeData = Route::match($pathinfo);
        if (!$routeData) {
            self::show404();
        }
        // 保存路由变量
        $GLOBALS['route'] = $routeData['args'];
        // 加载配置

        // 控制器路由
        if (strpos($routeData['path'], '/')) {
            self::runController($routeData);
            return;
        }
        // 命名空间路由
        if (strpos($routeData['path'], '\\')) {
            self::runLibrary($routeData);
            return;
        }
        self::showError();
    }

    // 执行控制器
    private static function runController($routeData)
    {
        // 实例化控制器
        $classPath = dirname($routeData['path']);
        $methodName = basename($routeData['path']);
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
