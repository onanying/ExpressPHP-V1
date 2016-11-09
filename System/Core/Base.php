<?php

/**
 * 基类
 * @author 刘健 <59208859>
 */

namespace Tiny\Core;

class Base
{

    protected $load;

    public function __construct()
    {
        $this->load = new Loader($this);
    }

}
