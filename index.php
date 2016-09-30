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

// 获取文件路径、类方法名
if (php_sapi_name() != 'cli') {
    $argv = __get_argv();
} else {
    if (empty($argv) || $argc < 2) {
        show_404();
    }
}

$file_path = ($argv[1] == '') ? 'welcome' : $argv[1];
$func_name = ($argv[2] == '') ? 'index' : $argv[2];

// 获取单例
$instance = get_instance();
$instance->load = new TP_Loader();

// 创建控制器
$object = controller($file_path);

// 判断类方法是否存在
if (!method_exists($object, $func_name)) {
    show_404();
}

// 执行控制器的类方法
$object->$func_name();
