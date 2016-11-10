<?php

/**
 * 模型 Sample
 * @author 刘健 <59208859>
 */

namespace Tiny\Model;

use Tiny\Common\Model;

class User extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserInfo()
    {
    	return array('name'=>'xiaohua', 'sex'=>'0', 'height'=>'168');
    }

}
