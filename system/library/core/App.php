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
            throw new \sys\exception\HttpException(404, '页面不存在');
        }
        self::runController($fullPath);
    }

    // 执行控制器
    private static function runController($fullPath)
    {
        // 实例化控制器
        $classPath = dirname($fullPath);
        $methodName = basename($fullPath);
        $namespace = '\\app\\' . str_ireplace('/', '\\', $classPath);
        $controller = new $namespace;
        // 执行控制器的方法
        $controller->$methodName();
    }

}
