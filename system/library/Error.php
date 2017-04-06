<?php

/**
 * Error类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Error
{

    private static $processed;

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
        throw new \sys\exception\ErrorException($errno, $errstr, $errfile, $errline);
    }

    // Error Handler
    public static function appShutdown()
    {
        if ($error = error_get_last()) {
            self::appException(new \sys\exception\ErrorException($error['type'], $error['message'], $error['file'], $error['line']));
        }
    }

    // Exception Handler
    public static function appException($e)
    {
        ob_clean();
        if ($e instanceof \sys\exception\HttpException) {
            echo $e->getStatusCode(), "\n";
            echo $e->getMessage(), "\n";
            echo $e->getFile(), "\n";
            echo $e->getLine(), "\n";
            echo $e->getTraceAsString(), "\n";
            return;
        }
        if (!Config::get('config.app_debug')) {
            echo '500', "\n";
            echo '服务器内部错误', "\n";
            return;
        }
        if ($e instanceof \sys\exception\ErrorException) {
            echo '系统错误', ":";
            echo $e->getMessage(), "\n";
            echo $e->getFile(), "\n";
            echo $e->getLine(), "\n";
            echo $e->getTraceAsString(), "\n";
            return;
        }
        if ($e instanceof \sys\exception\RouteException) {
            echo $e->getMessage(), "\n";
            echo $e->getLocation(), "\n";
            echo $e->getFile(), "\n";
            echo $e->getLine(), "\n";
            echo $e->getTraceAsString(), "\n";
            return;
        }
        if ($e instanceof \sys\exception\ConfigException) {
            echo $e->getMessage(), "\n";
            echo $e->getLocation(), "\n";
            echo $e->getFile(), "\n";
            echo $e->getLine(), "\n";
            echo $e->getTraceAsString(), "\n";
            return;
        }
        if ($e instanceof \sys\exception\ViewException) {
            echo $e->getMessage(), "\n";
            echo $e->getLocation(), "\n";
            echo $e->getFile(), "\n";
            echo $e->getLine(), "\n";
            echo $e->getTraceAsString(), "\n";
            return;
        }
        echo '未定义错误', ":";
        echo $e->getMessage(), "\n";
        echo $e->getFile(), "\n";
        echo $e->getLine(), "\n";
        echo $e->getTraceAsString(), "\n";
    }

}
