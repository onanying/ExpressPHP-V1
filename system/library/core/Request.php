<?php

/**
 * Request类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Request
{

    // PARAM 变量
    private static $param;

    // 变量过滤
    private static function filterValue(&$array, $name = '', $filter = '')
    {
        if (!isset($array[$name])) {
            return null;
        }
        switch ($filter) {
            case '':
                return $array[$name];
                break;
            case 'htmlspecialchars':
                return htmlspecialchars($array[$name]);
                break;
            case 'strip_tags':
                return strip_tags($array[$name]);
                break;
            default:
                return filter_var($array[$name], $filter);
                break;
        }
    }

    // 获取 PARAM 变量
    public static function param($name = '', $filter = '')
    {
        if (!isset(self::$param)) {
            self::$param = $_GET + $_POST;
        }
        return self::filterValue(self::$param, $name, $filter);
    }

    // 获取路由变量
    public static function route($name = '', $filter = '')
    {
        return self::filterValue($GLOBALS['route'], $name, $filter);
    }

    // 获取 $_GET 变量
    public static function get($name = '', $filter = '')
    {
        return self::filterValue($_GET, $name, $filter);
    }

    // 获取 $_POST 变量
    public static function post($name = '', $filter = '')
    {
        return self::filterValue($_POST, $name, $filter);
    }

    // 获取 $_REQUEST 变量
    public static function request($name = '', $filter = '')
    {
        return self::filterValue($_REQUEST, $name, $filter);
    }

    // 获取 $_SESSION 变量
    public static function session($name = '', $filter = '')
    {
        return self::filterValue($_SESSION, $name, $filter);
    }

    // 获取 $_COOKIE 变量
    public static function cookie($name = '', $filter = '')
    {
        return self::filterValue($_COOKIE, $name, $filter);
    }

    // 获取 $_FILES 变量
    public static function file($name = '', $filter = '')
    {
        return self::filterValue($_FILES, $name, $filter);
    }

    // 获取 $_SERVER 变量
    public static function server($name = '', $filter = '')
    {
        return self::filterValue($_SERVER, $name, $filter);
    }

    // 获取 $_ENV 变量
    public static function env($name = '', $filter = '')
    {
        return self::filterValue($_ENV, $name, $filter);
    }

}
