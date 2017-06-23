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
    	\Express::$app->request->setGet(['dd'=>'dd']);
    	$request = \Express::$app->request->create($request);
        return $request;
    }

    public function actionMyTest()
    {
        return \Express::$app->request->route();
    }

}
