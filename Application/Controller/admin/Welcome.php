<?php

/**
 * 控制器 Sample
 * @author 刘健 <59208859>
 */
class Welcome extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/UsersModel');
    }

    public function index()
    {
        $data['info'] = $this->UsersModel->getUserInfo();
        $this->load->view('sample', $data);
    }

}
