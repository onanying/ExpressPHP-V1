<?php

/**
 * 基类
 * @author 刘健 <59208859>
 */
class TP_Base
{

    protected $load;

    public function __construct()
    {
        $this->load = new TP_Loader($this);
    }

}
