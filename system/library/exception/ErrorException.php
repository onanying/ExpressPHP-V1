<?php

/**
 * ErrorException类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys\exception;

class ErrorException extends \RuntimeException
{

    protected $type;
    protected $file;
    protected $line;

    public function __construct($type, $message, $file, $line)
    {
        $this->type = $type;
        $this->message  = $message;
        $this->file = $file;
        $this->line = $line;
    }

}
