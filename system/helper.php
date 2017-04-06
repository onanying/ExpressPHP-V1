<?php

/**
 * 系统助手函数
 * @author 刘健 <code.liu@qq.com>
 */

// 视图
function view($template = null, $data = [])
{
    return new \sys\View($template, $data);
}
