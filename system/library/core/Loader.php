<?php

/**
 * 载入类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Loader
{

    public static function register()
    {
        // Composer自动加载支持
        if (is_dir(VENDOR_PATH . 'composer')) {
            self::registerComposerLoader();
        }
    }

    // 注册composer自动加载
    private static function registerComposerLoader()
    {
        require VENDOR_PATH . 'autoload.php';
    }

}
