<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

// Route::get('prodbyuser',[UserController::class  ,'index']);

Route::group(['prefix' => 'v1'], function (){

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('reset-password', 'resetPassword');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('products',  'index');
        Route::get('products/{id}', 'show');    
        
        Route::group(['middleware' => ['auth:sanctum']], function(){
            Route::post('products', 'store');
            Route::put('products/{id}',  'update');
            Route::delete('products/{id}', 'destroy');
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('prodbyuser',[UserController::class  ,'index']);

        });

    });
    
});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
