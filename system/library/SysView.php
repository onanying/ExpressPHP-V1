<?php

/**
 * SysView类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class SysView extends View
{

    public function __construct($template = null, $data = [])
    {
        parent::__construct($template, $data);
    }

    // 发送
    public function send()
    {
        echo self::import(SYS_PATH, $this->template, $this->data);
        exit;
    }

}
