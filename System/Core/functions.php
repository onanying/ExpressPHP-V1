<?php

/**
 * 系统函数库
 * @author 刘健 <59208859>
 */

// show 404
function show_404()
{
    echo 'ERROR: 404';
    exit;
}

// show error
function show_error($msg)
{
    echo 'ERROR: ' . $msg;
    exit;
}

// 获取实例
function get_instance()
{
    return TP_Storage::get_instance();
}

// 包含代码文件
function __include($file_dir, $file_name, $show_404 = false)
{
    $app_path = APP_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
    if (file_exists($app_path)) {
        include $app_path;
        return;
    }
    $sys_path = SYS_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
    if (file_exists($sys_path)) {
        include $sys_path;
        return;
    }
    $show_404 ? show_404() : show_error('[ Can not find a file ] ' . $app_path);
}

// 获取参数
function __get_argv()
{
    $request_url = parse_url($_SERVER['REQUEST_URI']);
    if (!$request_url) {
        show_404();
    }
    $argv[1] = substr(str_ireplace('/index.php', '', dirname($request_url['path'])), 1);
    $argv[2] = basename($request_url['path']);
    return $argv;
}

// 解析文件路径
function __parse_path($full_path)
{
    $full_path = str_ireplace(array('/', '\\'), DIRECTORY_SEPARATOR, $full_path);
    $file_path = dirname($full_path);
    $file_path = $file_path == '.' ? '' : DIRECTORY_SEPARATOR . $file_path;
    $file_name = basename($full_path);
    return array('file_dir' => $file_path, 'file_name' => $file_name);
}
