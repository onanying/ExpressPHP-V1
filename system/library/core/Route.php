<?php

/**
 * 路由类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Route
{

    // 变量规则数组
    private static $patterns;

    // 路由规则数组
    private static $rules;

    // 设置变量规则
    public static function pattern($key, $pattern)
    {
        self::$patterns[$key] = $pattern;
    }

    // 注册路由规则
    public static function rule($rule, $path)
    {
        self::$rules[] = ['rule' => self::convertRule($rule), 'path' => $path];
    }

    // 匹配操作路径
    public static function match($pathinfo)
    {
        foreach (self::$rules as $key => $rule) {
            if (preg_match($rule['rule']['pattern'], $pathinfo, $matches)) {
                $args = [];
                foreach ($rule['rule']['args'] as $key => $value) {
                    $args[$value] = $matches[$key + 1];
                }
                // 保存路由变量
                $GLOBALS['route'] = $args;
                // 返回解析后的控制器路径
                return self::convertPath($rule['path'], $args);
            }
        }
        return false;
    }

    // 转换路由规则
    private static function convertRule($rule)
    {
        $parts = explode('/', $rule);
        $args = [];
        foreach ($parts as $key => $part) {
            $partTag = substr($part, 0, 1);
            $partKey = substr($part, 1);
            if ($partTag == ':') {
                if (isset(self::$patterns[$partKey])) {
                    $parts[$key] = '(' . self::$patterns[$partKey] . ')';
                } else {
                    $parts[$key] = '(\w+)';
                }
                $args[] = $partKey;
            }
        }
        return ['pattern' => '/^\/' . implode('\/', $parts) . '/i', 'args' => $args];
    }

    // 转换路由路径
    private static function convertPath($path, $args)
    {
        $parts = explode('/', $path);
        foreach ($parts as $key => $part) {
            $partTag = substr($part, 0, 1);
            $partKey = substr($part, 1);
            if ($partTag == ':') {
                if (isset(self::$args[$partKey])) {
                    $parts[$key] = self::$args[$partKey];
                }
            }
        }
        return implode('/', $parts);
    }

}
