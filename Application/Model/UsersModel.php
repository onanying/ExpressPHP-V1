<?php

/**
 * 模型 Sample
 * @author 刘健 <59208859>
 */
class UsersModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $conf = array('ip' => '192.168.0.68', 'port' => '6379', 'passwd' => '123456');
        $this->load->db('RedisDriver', $conf);
    }

    public function getUserInfo()
    {
    	$ary = $this->RedisDriver->getTableRow('users', '10008'); // ary = array('name'=>'xiaohua', 'sex'=>'0', 'height'=>'168')
    	return $ary;
    }

}
