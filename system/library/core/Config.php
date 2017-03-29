<?php

/**
 * 配置类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Config
{

    // 配置加载
    public static function load($fileName)
    {
        if (!isset($GLOBALS['config'][$fileName])) {
            $GLOBALS['config'][$fileName] = self::import($fileName);
        }
    }

    // 包含配置文件
    private static function import($fileName)
    {
        $value = include APP_PATH . $fileName . '.php';
        return is_array($value) ? $value : [];
    }

    // 读取配置
    public static function get($argsPath = '')
    {
        // 全部配置
        if ($argsPath == '') {
            return $GLOBALS['config'];
        }
        $args = explode('.', $argsPath);
        $length = count($args);
        // 一级配置
        if ($length == 1) {
            $fileName = $args[0];
            return $GLOBALS['config'][$fileName];
        }
        // 二级配置
        if ($length == 2) {
            $fileName = $args[0];
            $argsName = $args[1];
            return $GLOBALS['config'][$fileName][$argsName];
        }
    }

    // 判断配置是否存在
    public static function has($argsPath = '')
    {
        // 全部配置
        if ($argsPath == '') {
            return isset($GLOBALS['config']) ? true : false;
        }
        $args = explode('.', $argsPath);
        $length = count($args);
        // 一级配置
        if ($length == 1) {
            $fileName = $args[0];
            return isset($GLOBALS['config'][$fileName]) ? true : false;
        }
        // 二级配置
        if ($length == 2) {
            $fileName = $args[0];
            $argsName = $args[1];
            return isset($GLOBALS['config'][$fileName][$argsName]) ? true : false;
        }
    }

}
