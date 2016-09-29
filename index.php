<?php

/**
 * 程序入口
 * @author 刘健 <59208859>
 */

// 全局常量定义
define('FC_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_PATH', FC_PATH . 'Application' . DIRECTORY_SEPARATOR);
define('SYS_PATH', FC_PATH . 'System' . DIRECTORY_SEPARATOR);

// 引入系统文件
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'functions.php';
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Loader.php';
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Base.php';
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Storage.php';
include APP_PATH . 'Common' . DIRECTORY_SEPARATOR . 'Controller.php';
include APP_PATH . 'Common' . DIRECTORY_SEPARATOR . 'Model.php';

// 获取文件路径、类名、类方法名
if (php_sapi_name() != 'cli') {
    $argv = __get_argv();
} else {
    if (empty($argv) || $argc < 2) {
        show_404();
    }
}
$file_path = $argv[1];
$class_name = ucfirst(strtolower(basename($argv[1])));
$func_name = isset($argv[2]) ? $argv[2] : 'index';

// 获取单例
$instance = get_instance();
$instance->load = new TP_Loader();

// 载入控制器
$instance->load->controller($file_path);

// 判断类方法是否存在
if (!method_exists($instance->$class_name, $func_name)) {
    show_404();
}

// 执行类方法
$instance->$class_name->$func_name();
