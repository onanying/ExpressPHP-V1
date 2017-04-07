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
        $location = Route::match($pathinfo);
        Route::destruct();
        if (!$location) {
            throw new \sys\exception\HttpException(404, 'URL不存在');
        }
        return self::runController($location);
    }

    // 执行控制器
    private static function runController($location)
    {
        // 实例化控制器
        $classPath  = dirname($location);
        $methodName = basename($location);
        $namespace  = '\\app\\' . str_ireplace('/', '\\', $classPath);
        try {
            $reflect = new \ReflectionClass($namespace);
        } catch (\ReflectionException $e) {
            throw new \sys\exception\RouteException('控制器未找到', $namespace);
        }
        $controller = $reflect->newInstanceArgs();
        // 判断方法是否存在
        if (!method_exists($controller, $methodName)) {
            throw new \sys\exception\RouteException('方法未找到', $namespace . '->' . $methodName . '()');
        }
        // 执行控制器的方法
        return Response::create($controller->$methodName());
    }

}
