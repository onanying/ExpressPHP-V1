<?php

use sys\Route;

/* 变量规则 */
Route::pattern('id', '\d+');

/* 注册路由规则 */
// 绑定方法模式
Route::rule('/*$', '\api\controller\Index->index'); // 首页
Route::rule('news/:method', '\api\controller\News->:method', Route::BIND_METHOD);
