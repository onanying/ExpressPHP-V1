<?php

/**
 * SysView类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys\response;

class SysView extends View
{

    // APP路径
    protected $appPath = SYS_PATH;

    public function __construct($template = null, $data = [])
    {
        parent::__construct($template, $data);
    }

}
