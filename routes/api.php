<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\User\PreferenceController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;

// Public routes with rate limiting it means 5 request per minut for same ip address
Route::middleware('throttle:5,1')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');
});

Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'throttle:5,1'])->name('logout');

// Authenticated routes with rate limiting it means 20 request per minut for same ip address
Route::middleware(['auth:sanctum', 'throttle:20,1'])->group(function () {
    // Article routes
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

    // Preference routes
    Route::post('save-preferences', [PreferenceController::class, 'store'])->name('preferences.store');
    Route::get('get-preferences', [PreferenceController::class, 'show'])->name('preferences.show');
    Route::get('preferences/news', [PreferenceController::class, 'getPersonalizedNews'])->name('preferences.news');

    // Get news articles
    Route::get('news/{query}', [NewsController::class, 'fetchAndSaveArticles'])->name('news.index');
    
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('sources', SourceController::class);
    Route::apiResource('authors', AuthorController::class);

});





