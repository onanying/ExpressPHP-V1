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
        // 获取配置
        $appDebug = Config::get('config.app_debug');
        // 清除无法接管的php系统语法错误
        ob_clean();

        // http异常处理
        if ($e instanceof \sys\exception\HttpException) {
            $httpExceptionTemplate = Config::get('config.http_exception');
            $data['message']       = $e->getStatusCode() . ' / ' . $e->getMessage();
            if ($appDebug) {
                $data['file']  = $e->getFile();
                $data['line']  = $e->getLine();
                $data['trace'] = $e->getTraceAsString();
            }
            $statusCode = $e->getStatusCode();
            $template   = $httpExceptionTemplate[$statusCode];
            if (!empty($template)) {
                if (is_array($template)) {
                    $class = \sys\response\Json::create($template);
                } else {
                    $class = \sys\response\View::create($template, $data);
                }
            } else {
                $class = \sys\response\Error::create($data);
            }
            $response = Response::create($class);
            $response->code($statusCode);
            $response->send();
        }

        // 其他异常处理
        $data['code'] = 500;
        if (!$appDebug) {
            $data['message'] = '500 / 服务器内部错误';
        } else if ($e instanceof \sys\exception\ErrorException) {
            $data['message'] = '系统错误 / ' . $e->getMessage();
        } else if ($e instanceof \sys\exception\RouteException) {
            $data['code']    = 404;
            $data['message'] = '路由错误 / ' . $e->getMessage() . ' / ' . $e->getLocation();
        } else if ($e instanceof \sys\exception\ConfigException) {
            $data['message'] = '配置错误 / ' . $e->getMessage() . ' / ' . $e->getLocation();
        } else if ($e instanceof \sys\exception\ViewException) {
            $data['message'] = '视图错误 / ' . $e->getMessage() . ' / ' . $e->getLocation();
        } else if ($e instanceof \sys\exception\TemplateException) {
            $data['message'] = '模板错误 / ' . $e->getMessage() . ' / ' . $e->getLocation();
        } else {
            $data['message'] = '未定义错误 / ' . $e->getMessage();
        }
        if ($appDebug) {
            $data['file']  = $e->getFile();
            $data['line']  = $e->getLine();
            $data['trace'] = $e->getTraceAsString();
        }
        $error    = \sys\response\Error::create($data);
        $response = Response::create($error);
        $response->code($data['code']);
        $response->send();
    }
}
