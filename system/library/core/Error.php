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
        if ($e instanceof \sys\exception\RouteException) {
            echo $e->getMessage(), "\n";
            echo $e->getLocation(), "\n";
        }
        if ($e instanceof \sys\exception\HttpException) {
            echo $e->getStatusCode(), "\n";
            echo $e->getMessage(), "\n";
        }
    }

    // Error Handler
    public static function appShutdown()
    {
        print_r(error_get_last());
    }

}
