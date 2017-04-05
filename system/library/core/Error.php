<?php

/**
 * Error类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Error
{

    // 注册异常处理
    public static function register()
    {
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    // Error Handler
    public static function appError($errno, $errstr, $errfile = '', $errline = 0, $errcontext = [])
    {
        if (!Config::get('config.app_debug')) {
            echo '500', "\n";
            echo '服务器内部错误', "\n";
            return;
        }
        $error = [
            'errno'      => $errno,
            'errstr'     => $errstr,
            'errfile'    => $errfile,
            'errline'    => $errline,
            'errcontext' => $errcontext,
        ];
        print_r($error);
    }

    // Exception Handler
    public static function appException($e)
    {
        if ($e instanceof \sys\exception\HttpException) {
            echo $e->getStatusCode(), "\n";
            echo $e->getMessage(), "\n";
            return;
        }
        if (!Config::get('config.app_debug')) {
            echo '500', "\n";
            echo '服务器内部错误', "\n";
            return;
        }
        if ($e instanceof \sys\exception\RouteException) {
            echo $e->getMessage(), "\n";
            echo $e->getLocation(), "\n";
            return;
        }
        if ($e instanceof \sys\exception\ConfigException) {
            echo $e->getMessage(), "\n";
            echo $e->getPath(), "\n";
            return;
        }
    }

    // Error Handler
    public static function appShutdown()
    {
        if (!Config::get('config.app_debug')) {
            echo '500', "\n";
            echo '服务器内部错误', "\n";
            return;
        }
        print_r(error_get_last());
    }

}
