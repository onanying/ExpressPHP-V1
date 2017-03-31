<?php

use sys\Route;

/* 变量规则 */
Route::pattern('id', '\d+');

/* 注册路由规则 */
// 标准模式
Route::rule('/', 'webpage/controller/Index/index');
Route::rule('news/*$', 'webpage/controller/News/index');
Route::rule('news/article/:id$', 'webpage/controller/News/article');
// 绑定方法模式
Route::rule('api/news/:method', 'webapi/controller/News/:method', Route::BIND_METHOD);
