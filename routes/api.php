<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
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

Route::group(['prefix'=>'v1'], function(){
    Route::post('login',[AuthController::class,'login'])
        ->name('auth.login');

    Route::group(['middleware'=>'auth'], function(){
        Route::post('logout',[AuthController::class,'logout'])
        ->middleware('auth')
        ->name('auth.logout');

        Route::resource('category',CategoryController::class)->only('index','store', 'update', 'destroy');
        Route::resource('product',ProductController::class)->only('index','store', 'update', 'destroy');
        Route::resource('image',ImageController::class)->only('index','store', 'update', 'destroy');
    });
});
