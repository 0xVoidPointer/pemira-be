<?php

use App\Http\Controllers\Api\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/test', fn () => response()->json(['message' => 'Hello World!']));

Route::prefix('admin/auth')->group(function () {
    Route::post('/', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth:web');
});
