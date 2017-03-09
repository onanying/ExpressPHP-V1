<?php

/**
 * 控制器 Sample
 * @author 刘健 <59208859@qq.com>
 */

namespace Tiny\Controller;

use Tiny\Common\Controller;

class Welcome extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $userModel = model('user');
        $data['info'] = $userModel->getUserInfo();
        view('sample', $data);
    }

}
