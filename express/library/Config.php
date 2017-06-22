<?php

/**
 * 配置类
 * @author 刘健 <code.liu@qq.com>
 */

namespace express;

class Config
{

    // 配置文件参数
    public $params;

    // 自动加载列表
    public $autoload;

    /**
     * 初始化
     */
    public function init()
    {
        // 自动加载
        foreach ($this->autoload as $file) {
            $this->load($file);
        }
    }

    /**
     * 加载配置
     * @param  string $file
     */
    public function load($file)
    {
        if (!isset($this->params[$file])) {
            $this->params[$file] = self::import($file);
        }
    }

    /**
     * 导入配置文件
     * @param  string $file
     * @return array
     */
    public static function import($file)
    {
        $filePath = \Express::$app->getConfigPath() . $file . '.php';
        if (!is_file($filePath)) {
            throw new \express\exception\ConfigException('配置文件不存在', $file . '.php');
        }
        $params = include $filePath;
        return is_array($params) ? $params : [];
    }

    // 读取配置
    public function get($name = '')
    {
        // 全部配置
        if ($name == '') {
            if (isset($this->params)) {
                return $this->params;
            }
        }
        $array  = explode('.', $name);
        $length = count($array);
        // 一级配置
        if ($length == 1) {
            list($oneLevel) = $array;
            if (isset($this->params[$oneLevel])) {
                return $this->params[$oneLevel];
            }
        }
        // 二级配置
        if ($length == 2) {
            list($oneLevel, $secondLevel) = $array;
            if (isset($this->params[$oneLevel][$secondLevel])) {
                return $this->params[$oneLevel][$secondLevel];
            }
        }
        // 三级配置
        if ($length == 3) {
            list($oneLevel, $secondLevel, $threeLevel) = $array;
            if (isset($this->params[$oneLevel][$secondLevel][$threeLevel])) {
                return $this->params[$oneLevel][$secondLevel][$threeLevel];
            }
        }
        throw new \sys\exception\ConfigException('配置项不存在', $name);
    }

    // 判断配置是否存在
    public function has($name = '')
    {
        $array  = explode('.', $name);
        $length = count($array);
        // 一级配置
        if ($length == 1) {
            list($oneLevel) = $array;
            return isset($this->params[$oneLevel]) ? true : false;
        }
        // 二级配置
        if ($length == 2) {
            list($oneLevel, $secondLevel) = $array;
            return isset($this->params[$oneLevel][$secondLevel]) ? true : false;
        }
        // 三级配置
        if ($length == 3) {
            list($oneLevel, $secondLevel, $threeLevel) = $array;
            return isset($this->params[$oneLevel][$secondLevel][$threeLevel]) ? true : false;
        }
        return false;
    }

}
