<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace app\controller;

use sys\Config;

class Index
{

    public function index()
    {
        var_dump(Config::get());
    }

}
