<?php

/**
 * 控制器 Sample
 * @author 刘健 <59208859>
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
        $usersModel = model('user');
        $data['info'] = $usersModel->getUserInfo();
        view('sample', $data);
    }

}
