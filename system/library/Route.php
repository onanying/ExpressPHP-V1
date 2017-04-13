<?php

/**
 * Route类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Route
{

    // 标准模式
    const STANDARD = 0;

    // 控制器模式
    const BIND_METHOD = 1;

    // 变量规则数组
    private static $patterns;

    // 路由规则数组
    private static $rules;

    // 默认变量规则
    private static $defaultPattern = '[\w-]+';

    // 默认变量规则
    private static $defaultMethod = 'index';

    // 设置变量规则
    public static function pattern($key, $pattern)
    {
        self::$patterns[$key] = $pattern;
    }

    // 注册路由规则
    public static function rule($rule, $path, $mode = self::STANDARD)
    {
        self::$rules[] = ['rule' => self::convertRule($rule, $mode), 'path' => $path];
    }

    // 匹配操作路径
    public static function match($pathinfo)
    {
        $location = false;
        foreach (self::$rules as $key => $rule) {
            switch ($rule['rule']['mode']) {
                case self::STANDARD:
                    $location = self::standardMatch($rule, $pathinfo);
                    break;
                case self::BIND_METHOD:
                    $location = self::bindMethodMatch($rule, $pathinfo);
                    break;
            }
            if ($location) {
                return $location;
            }
        }
        return $location;
    }

    // 标准模式匹配
    private static function standardMatch($rule, $pathinfo)
    {
        if (preg_match($rule['rule']['pattern'], $pathinfo, $matches)) {
            $args = [];
            foreach ($rule['rule']['args'] as $key => $value) {
                $args[$value] = $matches[$key + 1];
            }
            // 保存路由变量
            $GLOBALS['route'] = $args;
            // 返回解析后的控制器路径
            return $rule['path'];
        }
    }

    // 绑定方法模式匹配
    private static function bindMethodMatch($rule, $pathinfo)
    {
        foreach ($rule['rule']['pattern'] as $pattern) {
            if (preg_match($pattern, $pathinfo, $matches)) {
                $args = [];
                foreach ($rule['rule']['args'] as $key => $value) {
                    if (isset($matches[$key + 1])) {
                        $args[$value] = $matches[$key + 1];
                    } else {
                        $args[$value] = self::$defaultMethod;
                    }
                }
                // 保存路由变量
                $GLOBALS['route'] = $args;
                // 返回解析后的控制器路径
                return self::convertPath($rule['path'], $args);
            }
        }
    }

    // 转换路由规则
    private static function convertRule($rule, $mode)
    {
        switch ($mode) {
            case self::STANDARD:
                return self::standardConvertRule($rule);
                break;
            case self::BIND_METHOD:
                return self::bindMethodConvertRule($rule);
                break;
        }
    }

    // 标准模式转换
    private static function standardConvertRule($rule)
    {
        $endMark = self::fetchEndMark($rule);
        $rule    = substr($rule, 0, -1);
        $parts   = explode('/', $rule);
        $args    = [];
        foreach ($parts as $key => $part) {
            $partTag = substr($part, 0, 1);
            $partKey = substr($part, 1);
            if ($partTag == ':') {
                if (isset(self::$patterns[$partKey])) {
                    $parts[$key] = '(' . self::$patterns[$partKey] . ')';
                } else {
                    $parts[$key] = '(' . self::$defaultPattern . ')';
                }
                $args[] = $partKey;
            }
        }
        return [
            'pattern' => '/^\/' . implode('\/', $parts) . $endMark . '/i',
            'args'    => $args,
            'mode'    => self::STANDARD,
        ];
    }

    // 绑定方法模式转换
    private static function bindMethodConvertRule($rule)
    {
        $endMark  = self::fetchEndMark($rule);
        $rule     = substr($rule, 0, -1);
        $parts    = explode('/', $rule);
        $args     = [];
        $lastPart = array_pop($parts);
        $partTag  = substr($lastPart, 0, 1);
        $partKey  = substr($lastPart, 1);
        if ($partTag == ':') {
            if (isset(self::$patterns[$partKey])) {
                $lastPart = '(' . self::$patterns[$partKey] . ')';
            } else {
                $lastPart = '(' . self::$defaultPattern . ')';
            }
            $args[] = $partKey;
        }
        return [
            'pattern' => [
                '/^\/' . implode('\/', $parts) . '\/' . $lastPart . $endMark . '/i',
                '/^\/' . implode('\/', $parts) . $endMark . '/i',
            ],
            'args'    => $args,
            'mode'    => self::BIND_METHOD,
        ];
    }

    // 提取结束标记
    private static function fetchEndMark($rule)
    {
        $lastWord = substr($rule, -1);
        return $lastWord == '$' ? '$' : '';
    }

    // 转换路由路径
    private static function convertPath($path, $args)
    {
        $parts = explode('/', $path);
        foreach ($parts as $key => $part) {
            $partTag = substr($part, 0, 1);
            $partKey = substr($part, 1);
            if ($partTag == ':') {
                if (isset($args[$partKey])) {
                    $parts[$key] = $args[$partKey];
                }
            }
        }
        return implode('/', $parts);
    }

    // 销毁路由配置
    public static function destruct()
    {
        self::$patterns = null;
        self::$rules    = null;
    }

}
