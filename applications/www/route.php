<?php

use sys\Route;

/* 变量规则 */
Route::pattern('id', '\d+');

/* 注册路由规则 */
// 标准模式
Route::rule('/*$', '/www/controller/Index->index'); // 首页
Route::rule('news/*$', '\www\controller\News->index'); // 目录
Route::rule('news/forum/:flag$', '\www\controller\News->forum');
Route::rule('news/article/:id$', '\www\controller\News->article');
