<?php

/**
 * Mysql类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys\mysql;

class Statement
{

    // PDOStatement对象
    private $PDOStatement;

    // 是否为驼峰命名
    private $isCamelCase = false;

    public function __construct($PDOStatement)
    {
        $this->PDOStatement = $PDOStatement;
        $appConf            = Config::get('config.mysql');
        if ($appConf['column_name_mode'] == 'camelcase') {
            $this->isCamelCase = true;
        }
    }

    // 调用方法
    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->PDOStatement, $method], $args);
    }

    // 获取属性
    public function __get($name)
    {
        return $this->PDOStatement->$name;
    }

    // 转换结果集
    private static function convert($result)
    {
        if (empty($result)) {
            return $result;
        }
        // 转换列名
        $row     = $result[0];
        $isArray = is_array($row);
        $column  = [];
        foreach ($row as $key => $value) {
            $column[$key] = self::convertUnderline($key);
        }
        // 重构数据
        $newResult = [];
        foreach ($result as $key => $value) {
            $tmp = [];
            foreach ($value as $k => $v) {
                $tmp[$column[$k]] = $v;
            }
            $newResult[] = $isArray ? $tmp : (object) $tmp;
        }
        return $newResult;
    }

    // 将下划线命名转换为驼峰式命名
    public static function convertUnderline($str, $ucfirst = false)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }

}
