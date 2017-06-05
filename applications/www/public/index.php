<?php

// 定义应用目录
define('APP_PATH', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
define('SYS_PATH', realpath(__DIR__ . '/../../../system') . DIRECTORY_SEPARATOR);

// 加载框架引导文件
require SYS_PATH . 'start.php';
