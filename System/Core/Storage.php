<?php

/**
 * 对象仓库类
 * @author 刘健 <59208859>
 */

namespace Tiny\Core;

class Storage
{

    private static $_instance;

    public $library = (object)[];
    public $model = (object)[];
    public $db = (object)[];

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
