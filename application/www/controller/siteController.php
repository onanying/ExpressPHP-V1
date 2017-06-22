<?php

/**
 * 控制器
 * @author 刘健 <code.liu@qq.com>
 */

namespace www\controller;

class siteController
{

    public function actionIndex($request)
    {
        // \Express::$app->request->init($request);
        // \Express::$app->request->get();
        // \Express::$app->request->post();
        return $request;
    }

    public function actionMyTest($request)
    {
        return $request;
    }

}
