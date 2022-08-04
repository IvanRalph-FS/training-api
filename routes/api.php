<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/sanctum/token', \App\Http\Controllers\Api\Auth\TokenController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', \App\Http\Controllers\Api\User\UserController::class)->middleware('admin');

    Route::get('article-categories/list-all', [
        \App\Http\Controllers\Api\ArticleCategory\ArticleCategoryController::class,
        'listAll'
    ]);

    Route::apiResource('article-categories', \App\Http\Controllers\Api\ArticleCategory\ArticleCategoryController::class);

    Route::apiResource('articles', \App\Http\Controllers\Api\Article\ArticleController::class);

    Route::get('/auth/check', [\App\Http\Controllers\Api\User\UserController::class, 'auth']);
});
