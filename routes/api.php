<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\User\PreferenceController;
use App\Http\Controllers\NewsController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    // Article routes
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

    // Preference routes
    Route::post('preferences', [PreferenceController::class, 'store'])->name('preferences.store');
    Route::get('preferences', [PreferenceController::class, 'show'])->name('preferences.show');
    // get news articles
    Route::get('news/{query}', [NewsController::class, 'fetchAndSaveArticles'])->name('news.index');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
