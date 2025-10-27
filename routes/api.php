<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TranslationController;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(\App\Http\Middleware\AuthenticateWithToken::class)->group(function () {
    Route::apiResource('languages', LanguageController::class)->only(['index', 'store']);
    Route::apiResource('tags', TagController::class)->only(['index', 'store']);
    Route::get('translations/export/{locale}', [TranslationController::class, 'export']);
    Route::apiResource('translations', TranslationController::class)->only(['index', 'store', 'update']);
});
