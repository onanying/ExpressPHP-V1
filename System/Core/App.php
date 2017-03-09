<?php

/**
 * 应用程序类
 * @author 刘健 <59208859@qq.com>
 */

namespace Tiny\Core;

use Tiny\Core\Router;

class App
{

	// 运行
    public static function run()
    {
        // 获取文件路径、类方法名
        if (php_sapi_name() != 'cli') {
            $argv = Router::getArgv();
        } else {
            if (empty($argv) || $argc < 2) {
                show_404();
            }
        }

        // 默认路由
        $filePath = ($argv[1] == '') ? 'welcome' : $argv[1];
        $funcName = ($argv[2] == '') ? 'index' : $argv[2];

		// 创建控制器
        $controller = controller($filePath);

		// 判断类方法是否存在
        if (!method_exists($controller, $funcName)) {
            show_404();
        }

		// 执行控制器的类方法
        $controller->$funcName();
    }

}
