<?php

/**
 * ConfigException类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys\exception;

class ConfigException extends \RuntimeException
{

    protected $path;

    public function __construct($message, $path)
    {
        $this->message  = $message;
        $this->path = $path;
    }

    // 获取路径
    public function getPath()
    {
        return $this->path;
    }

}
