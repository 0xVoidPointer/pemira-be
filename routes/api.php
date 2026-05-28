<?php

use App\Http\Controllers\Api\Auth\StudentAuthController;
use App\Http\Controllers\Api\ElectionController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['message' => 'server is up']));

Route::prefix('student/auth')->group(function () {
    Route::post('/', [StudentAuthController::class, 'login']);
    Route::get('/verify', fn () => null)->middleware('auth:api');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->middleware('auth:api');
});

Route::prefix('election/active-period')->group(function () {
    Route::get('/', [ElectionController::class, 'activePeriod']);
    Route::get('/categories', [ElectionController::class, 'activePeriodCategories'])->middleware('auth:api');
    Route::get('/categories/{categoryId}/candidates', [ElectionController::class, 'activePeriodCandidates'])->middleware('auth:api');
    Route::post('/votes', [ElectionController::class, 'activePeriodCandidatesVotes'])->middleware('auth:api');
});
