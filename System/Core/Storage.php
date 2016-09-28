<?php

/**
 * 对象仓库类
 * @author 刘健 <59208859>
 */
class TP_Storage
{

    private static $_instance;

    private function __construct()
    {}

    public static function get_instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}
