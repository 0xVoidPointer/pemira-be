<?php

use Illuminate\Support\Facades\Route;

// SPA catch-all (exclude admin panel routes)
Route::get('/{any}', function () {
    return view('entry');
})->where('any', '^(?!admin).*$');
