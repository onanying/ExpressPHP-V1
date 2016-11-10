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
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Router.php';
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Loader.php';
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'Base.php';
include SYS_PATH . 'Core' . DIRECTORY_SEPARATOR . 'App.php';
include APP_PATH . 'Common' . DIRECTORY_SEPARATOR . 'Controller.php';
include APP_PATH . 'Common' . DIRECTORY_SEPARATOR . 'Model.php';

// 启动APP
Tiny\Core\App::run();
