<?php

/**
 * URL路由类
 * @author 刘健 <59208859>
 */

namespace Tiny\Core;

class Router
{

    // 解析文件路径
    public static function parsePath($file_path, $ucfirst = false)
    {
        $file_path = str_ireplace(array('/', '\\'), DIRECTORY_SEPARATOR, $file_path);
        $file_dir = dirname($file_path);
        $file_dir = ($file_dir == '.') ? '' : DIRECTORY_SEPARATOR . $file_dir;
        $file_name = basename($file_path);
        return array('file_dir' => $file_dir, 'file_name' => $ucfirst ? ucfirst(strtolower($file_name)) : $file_name);
    }

	// 从URL获取参数
    public static function getArgv()
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
            $info = self::parsePath(dirname($url_path), true);
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

}
