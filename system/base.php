<?php

// 框架常量
define('DS', DIRECTORY_SEPARATOR);
defined('SYS_PATH') or define('SYS_PATH', __DIR__ . DS);
define('LIB_PATH', SYS_PATH . 'library' . DS);
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
defined('CONF_PATH') or define('CONF_PATH', APP_PATH . 'config' . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . DS);
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'temp' . DS);

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);

// 载入Loader类
require LIB_PATH . 'Loader.php';

// 载入注册
\sys\Loader::register();
