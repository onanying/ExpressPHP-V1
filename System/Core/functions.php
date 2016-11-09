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
    return Storage::get_instance();
}

// 解析文件路径
function __parse_path($file_path, $ucfirst = false)
{
    $file_path = str_ireplace(array('/', '\\'), DIRECTORY_SEPARATOR, $file_path);
    $file_dir = dirname($file_path);
    $file_dir = ($file_dir == '.') ? '' : DIRECTORY_SEPARATOR . $file_dir;
    $file_name = basename($file_path);
    return array('file_dir' => $file_dir, 'file_name' => $ucfirst ? ucfirst(strtolower($file_name)) : $file_name);
}

// 获取参数
function __get_argv()
{
    $request_url = parse_url($_SERVER['REQUEST_URI']);
    if (!$request_url) {
        show_404();
    }
    $url_path = substr(str_ireplace('/index.php', '', $request_url['path']), 1);
    $fragments = count(explode('/', $url_path));
    if ($fragments == 1) {
        $file_path = $url_path;
        $func_name = '';
    }
    if ($fragments == 2) {
        // uri为两段时的歧义处理
        $info = __parse_path(dirname($url_path), true);
        $app_path = APP_PATH . 'Controller' . $info['file_dir'] . DIRECTORY_SEPARATOR . $info['file_name'] . '.php';
        if (is_file($app_path)) {
            $file_path = dirname($url_path);
            $func_name = basename($request_url['path']);            
        } else {
            $file_path = $url_path;
            $func_name = '';
        }
    }
    if ($fragments > 2) {
        $file_path = dirname($url_path);
        $func_name = basename($request_url['path']);
    }
    $argv[1] = $file_path;
    $argv[2] = $func_name;
    return $argv;
}

// 包含代码文件
function __include($file_dir, $file_name)
{
    $app_path = APP_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
    if (is_file($app_path)) {
        include $app_path;
        return;
    }
    $sys_path = SYS_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
    if (is_file($sys_path)) {
        include $sys_path;
        return;
    }
    show_error('[ Can not find a file ] ' . $app_path);
}

// 创建控制器
function controller($file_path)
{
    $info = __parse_path($file_path, true);
    $app_path = APP_PATH . 'Controller' . $info['file_dir'] . DIRECTORY_SEPARATOR . $info['file_name'] . '.php';
    is_file($app_path) or show_404();
    include $app_path;
    return new $info['file_name'];
}
