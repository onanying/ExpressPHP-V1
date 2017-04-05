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
        $filePath = CONF_PATH . $fileName . '.php';
        if (!is_file($filePath)) {
            throw new \sys\exception\ConfigException('配置文件不存在', $fileName . '.php');
        }
        $value = include $filePath;
        return is_array($value) ? $value : [];
    }

    // 读取配置
    public static function get($argsPath = '')
    {
        // 全部配置
        if ($argsPath == '') {
            if (isset($GLOBALS['config'])) {
                return $GLOBALS['config'];
            }
        }
        $args   = explode('.', $argsPath);
        $length = count($args);
        // 一级配置
        if ($length == 1) {
            $fileName = $args[0];
            if (isset($GLOBALS['config'][$fileName])) {
                return $GLOBALS['config'][$fileName];
            }
        }
        // 二级配置
        if ($length == 2) {
            $fileName = $args[0];
            $argsName = $args[1];
            if (isset($GLOBALS['config'][$fileName][$argsName])) {
                return $GLOBALS['config'][$fileName][$argsName];
            }
        }
        throw new \sys\exception\ConfigException('配置项不存在', $argsPath);
    }

    // 判断配置是否存在
    public static function has($argsPath = '')
    {
        $args   = explode('.', $argsPath);
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
        return false;
    }

}
