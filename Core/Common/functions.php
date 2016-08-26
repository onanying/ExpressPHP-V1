<?php

/**
 * 系统函数库
 * @author 刘健 <59208859>
 */

// 获取实例
function &get_instance()
{
	global $instance;
    return $instance;
}

// 包含代码文件
function _include($file_dir, $file_name)
{
    $file_path = APP_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
    if (!file_exists($file_path)) {
        throw new Exception('Error 404');
    }
    require_once $file_path;
}
