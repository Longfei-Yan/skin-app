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

Route::prefix('v1')->name('api.v1.')->group(function (){
    Route::post('/register', [\App\Http\Controllers\Api\UserController::class, 'store']);

    Route::group([
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
        Route::delete('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        Route::put('/refresh', [\App\Http\Controllers\Api\AuthController::class, 'refresh']);
        Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me']);
    });

    Route::get('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'index']);
    Route::get('/sayings', [\App\Http\Controllers\Api\ArticleController::class, 'saying']);
    Route::get('/jokes', [\App\Http\Controllers\Api\ArticleController::class, 'joke']);
});
