<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('entry');
});

Route::get('/docs', fn () => view('openapi'));
