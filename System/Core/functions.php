<?php

/**
 * 公共函数库
 * @author 刘健 <59208859>
 */

// 显示404错误页面
function show_404()
{
    echo 'ERROR: 404';
    exit;
}

// 显示错误页面
function show_error($msg)
{
    echo 'ERROR: ' . $msg;
    exit;
}

// 创建控制器
function controller($file_path)
{
    return Tiny\Core\Loader::controller($file_path);
}

// 创建模型
function model($file_path, $params = null)
{
    return Tiny\Core\Loader::model($file_path, $params);
}

// 创建数据库驱动
function db($file_path, $params = null)
{
    return Tiny\Core\Loader::db($file_path, $params);
}

// 载入辅助函数
function helper($file_path)
{
    return Tiny\Core\Loader::helper($file_path);
}

// 载入视图
function view($filePath, $params = null)
{
    return Tiny\Core\Loader::view($filePath, $params);
}
