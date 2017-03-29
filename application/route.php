<?php

use sys\Route;

Route::pattern('name', '\w+');
Route::pattern('id', '\d+');
Route::rule('new/index', 'Index/index');
Route::rule(':v/new/index', ':v/Index/index');
