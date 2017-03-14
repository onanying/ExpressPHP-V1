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
    public static function rule($key, $rule)
    {
        self::$rules[$key] = $rule;
    }

    // 匹配操作路径
    public static function match()
    {
        foreach ($rules as $key => $rule) {
            
        }
    }

    // 转换规则为正则
    private static function convertRule($ruleKey)
    {
        $parts = explode('/', $ruleKey);

        foreach ($parts as $key => $part) {
            $partTag = substr($part, 0, 1);
            $partKey = substr($part, 1);
            if ($tag == ':') {
                if (isset($patterns[$partKey])) {
                    $parts[$key] = '(' . $patterns[$partKey] . ')';
                }
            }
        }

        echo '/' . implode('\/', $parts) . '/i';
    }

}
