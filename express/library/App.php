<?php

/**
 * App类
 * @author 刘健 <code.liu@qq.com>
 */

namespace express;

class App
{

    public function __construct($config)
    {
        // 添加属性
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
        // 快捷引用
        \Express::$app = $this;
    }

    public function __get($name)
    {
        return self::$app->$name;
    }

    public function run()
    {
        var_dump(\Express::$app->dfd);
    }

}
