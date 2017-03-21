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
        self::$rules[] = ['rule' => self::convert($rule), 'path' => $path];
    }

    // 匹配操作路径
    public static function match($pathinfo)
    {
        foreach (self::$rules as $key => $rule) {
            if(preg_match($rule['rule']['pattern'], $pathinfo, $matches)){
                $args = [];
                foreach ($rule['rule']['args'] as $key => $value) {
                    $args[$value] = $matches[$key + 1];
                }
                return ['path'=>$rule['path'], 'args' => $args];
            }
        }
        return false;
    }

    // 转换规则为正则并提取参数名
    private static function convert($rule)
    {
        $parts = explode('/', $rule);
        $args = [];
        foreach ($parts as $key => $part) {            
            $partTag = substr($part, 0, 1);
            $partKey = substr($part, 1);
            if ($partTag == ':') {
                if (isset(self::$patterns[$partKey])) {
                    $parts[$key] = '(' . self::$patterns[$partKey] . ')';
                }else{
                    $parts[$key] = '(\w+)';
                }
                $args[] = $partKey;
            }
        }
        return ['pattern'=>'/^\/' . implode('\/', $parts) . '/i', 'args' => $args];
    }

}
