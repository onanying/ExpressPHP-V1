<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\controller;

class Index
{

    public function index()
    {
        $args = func_get_args();
        var_dump($args);
    }

}
