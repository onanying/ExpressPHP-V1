<?php

/**
 * 程序入口
 * @author 刘健 <59208859>
 */

// 参数效验
if (php_sapi_name() != 'cli') {
    die('Please run under the cli');
}
if (empty($argv) || $argc < 2) {
    die('Error 404');
}

$class_name = $argv[1];
$func_name = isset($argv[2]) ? $argv[2] : 'index';

// 全局常量定义
define('FC_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_PATH', FC_PATH . 'Application' . DIRECTORY_SEPARATOR);

// 引入系统文件
include FC_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Base.class.php';
include FC_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'Autoload.class.php';
include FC_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Common' . DIRECTORY_SEPARATOR . 'functions.php';

// 初始化全局实例池
$instance = new stdClass();
$instance->load = new Autoload();

try {
    // 初始化控制器
    $instance->load->controller($class_name);
} catch (Exception $e) {
    die($e->getMessage());
}

// 判断函数是否存在
if (!method_exists($instance->$class_name, $func_name)) {
    die('Error 404');
}

// 运行函数
$instance->$class_name->$func_name();
