<?php

/**
 * 加载类
 * @author 刘健 <59208859>
 */

namespace Tiny\Core;

class Loader
{

    private static $file = array(); // 文件引用记录

    // 包含代码文件
    private static function import($file_dir, $file_name)
    {
        if (isset(self::$file[$file_dir . $file_name])) {
            return true;
        } else {
            self::$file[$file_dir . $file_name] = true;
        }
        $app_path = APP_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
        if (is_file($app_path)) {
            include $app_path;
            return true;
        }
        $sys_path = SYS_PATH . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.php';
        if (is_file($sys_path)) {
            include $sys_path;
            return true;
        }
        return false;
    }

    // 控制器
    public static function controller($file_path)
    {
        $fileInfo = Router::parsePath($file_path, true);
        self::import('Controller' . $fileInfo['file_dir'], $fileInfo['file_name']) or show_404();
        $className = "Tiny\\Controller\\{$fileInfo['file_name']}";     
        return new $className;
    }

    // 模型
    public static function model($file_path, $params = null)
    {
        $fileInfo = Router::parsePath($file_path);
        self::import('Model' . $fileInfo['file_dir'], $fileInfo['file_name']) or show_error('[ Can not find a Model file ] ' . $file_path);
        $className = "Tiny\\Model\\{$fileInfo['file_name']}";
        return new $className;
    }

    // 类库
    public static function library($file_path, $params = null)
    {
        $fileInfo = Router::parsePath($file_path);
        self::import('Library' . $fileInfo['file_dir'], $fileInfo['file_name']) or show_error('[ Can not find a Library file ] ' . $file_path);
        $className = "Tiny\\Library\\{$fileInfo['file_name']}";
        return new $className;
    }

    // 数据库驱动
    public static function db($file_path, $params = null)
    {
        $fileInfo = Router::parsePath($file_path);
        self::import('Db' . $fileInfo['file_dir'], $fileInfo['file_name']) or show_error('[ Can not find a Db file ] ' . $file_path);
        $className = "Tiny\\Db\\{$fileInfo['file_name']}";
        return new $className;
    }

    // 辅助函数
    public static function helper($file_path)
    {
        $fileInfo = Router::parsePath($file_path);
        self::import('Helper' . $fileInfo['file_dir'], $fileInfo['file_name']) or show_error('[ Can not find a Helper file ] ' . $file_path);
        return true;
    }

    // 视图
    public static function view($__filePath__, $__params__ = null)
    {
        // 申明变量
        foreach (array_keys($__params__) as $__key__) {
            $$__key__ = $__params__[$__key__];
        }
        // 载入视图
        $__fileInfo__ = Router::parsePath($__filePath__);
        $__viewPath__ = APP_PATH . 'View' . $__fileInfo__['file_dir'] . DIRECTORY_SEPARATOR . $__fileInfo__['file_name'] . '.php';
        if (!is_file($__viewPath__)) {
            show_error('[ Can not find a View file ] ' . $__filePath__);
        }
        include $__viewPath__;
        return true;
    }

}
