<?php

use sys\Route;

Route::pattern('name', '\w+');
Route::pattern('id', '\d+');
Route::rule('new/:id/:name', 'Index/index');
Route::rule('new/index', 'Index/index');
