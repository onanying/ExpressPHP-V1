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

    // 导入配置文件
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
    public static function get($location = '')
    {
        // 全部配置
        if ($location == '') {
            if (isset($GLOBALS['config'])) {
                return $GLOBALS['config'];
            }
        }
        $array = explode('.', $location);
        $length = count($array);
        // 一级配置
        if ($length == 1) {
            list($oneLevel) = $array;
            if (isset($GLOBALS['config'][$oneLevel])) {
                return $GLOBALS['config'][$oneLevel];
            }
        }
        // 二级配置
        if ($length == 2) {
            list($oneLevel, $secondLevel) = $array;
            if (isset($GLOBALS['config'][$oneLevel][$secondLevel])) {
                return $GLOBALS['config'][$oneLevel][$secondLevel];
            }
        }
        // 三级配置
        if ($length == 3) {
            list($oneLevel, $secondLevel, $threeLevel) = $array;
            if (isset($GLOBALS['config'][$oneLevel][$secondLevel][$threeLevel])) {
                return $GLOBALS['config'][$oneLevel][$secondLevel][$threeLevel];
            }
        }
        throw new \sys\exception\ConfigException('配置项不存在', $location);
    }

    // 判断配置是否存在
    public static function has($location = '')
    {
        $array = explode('.', $location);
        $length = count($array);
        // 一级配置
        if ($length == 1) {
            list($oneLevel) = $array;
            return isset($GLOBALS['config'][$oneLevel]) ? true : false;
        }
        // 二级配置
        if ($length == 2) {
            list($oneLevel, $secondLevel) = $array;
            return isset($GLOBALS['config'][$oneLevel][$secondLevel]) ? true : false;
        }
        // 三级配置
        if ($length == 3) {
            list($oneLevel, $secondLevel, $threeLevel) = $array;
            return isset($GLOBALS['config'][$oneLevel][$secondLevel][$threeLevel]) ? true : false;
        }
        return false;
    }

}
