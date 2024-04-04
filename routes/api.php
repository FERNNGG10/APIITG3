<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\UserController;
use App\Models\Sensor;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('register',[AuthController::class,'register']);
    Route::middleware('status')->post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('me', [AuthController::class,'me']);
    Route::get('active/{user}',[AuthController::class,'active'])->middleware('signed')->name('active');

});

Route::middleware(['auth:api','isactive'])->prefix('sensors')->group(function(){
    Route::get('index',[SensorController::class,'index']);
    Route::post('store',[SensorController::class,'store']);
    Route::put('update/{id}',[SensorController::class,'update'])->where('id', '[0-9]+');
    Route::delete('destroy/{id}',[SensorController::class,'destroy'])->where('id', '[0-9]+');
});

Route::middleware(['auth:api','isactive'])->prefix('users')->group(function(){
    Route::get('index',[UserController::class,'index']);
    Route::post('store',[UserController::class,'store']);
    Route::get('active/{user}',[AuthController::class,'active'])->middleware('signed')->name('active');
    Route::put('update/{id}',[UserController::class,'update'])->where('id', '[0-9]+');
    Route::delete('destroy/{id}',[UserController::class,'destroy'])->where('id', '[0-9]+');;
});