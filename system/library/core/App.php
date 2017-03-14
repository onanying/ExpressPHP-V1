<?php

/**
 * App类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class App
{

    public static function run()
    {
    	$pathinfo =  isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    	var_dump(Route::match($pathinfo));
    }

}
