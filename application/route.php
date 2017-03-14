<?php

use sys\Route;

Route::pattern('name', '\w+');
Route::pattern('id', '\d+');
Route::rule('new/:id', 'Index/index');
