<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MongoController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\UserController;
use App\Models\Plant;
use App\Models\Rol;
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
    Route::post('register', [AuthController::class, 'register']);
    Route::middleware('status')->post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('active/{user}', [AuthController::class, 'active'])->middleware('signed')->name('active');
    Route::get('getrol',[AuthController::class,'rolid']);
    Route::get('getstatus',[AuthController::class,'status']);
    Route::post('changepassword',[AuthController::class,'changePassword']);
   
});



Route::middleware(['auth:api', 'isactive'])->prefix('v1')->group(function(){

    Route::middleware('isadmin')->prefix('sensors')->group(function () {
        Route::get('index', [SensorController::class, 'index']);
        Route::post('store', [SensorController::class, 'store']);
        Route::put('update/{id}', [SensorController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('destroy/{id}', [SensorController::class, 'destroy'])->where('id', '[0-9]+');
        Route::get('show/{id}',[SensorController::class,'show'])->where('id', '[0-9]+');
    });
    Route::middleware('isadmin')->prefix('roles')->group(function () {
        Route::get('index', [RolController::class, 'index']);
        Route::post('store', [RolController::class, 'store']);
        Route::put('update/{id}', [RolController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('destroy/{id}', [RolController::class, 'destroy'])->where('id', '[0-9]+');;
        Route::get('show/{id}',[RolController::class,'show'])->where('id', '[0-9]+');
    });
    Route::middleware('isadmin')->prefix('users')->group(function () {
        Route::get('index', [UserController::class, 'index']);
        Route::post('store', [UserController::class, 'store']);
        Route::put('update/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('destroy/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');;
        Route::get('show/{id}',[UserController::class,'show'])->where('id', '[0-9]+');
    });
    
    Route::prefix('plants')->group(function () {
        Route::get('index',[PlantController::class,'index']);
        Route::post('store',[PlantController::class,'store']);
        Route::put('update/{id}',[PlantController::class,'update']);
        Route::delete('destroy/{id}',[PlantController::class,'destroy']);
        Route::get('show/{id}',[PlantController::class,'show'])->where('id', '[0-9]+');
        Route::get('inactive',[PlantController::class,'inactivePlants']);
        Route::get('active',[PlantController::class,'activePlants']);
    });

    Route::prefix('websocket')->group(function(){
        Route::get('last',[MongoController::class,'last']);
        Route::get('ios/last',[MongoController::class,'ioslast']);
        Route::post('bomb',[MongoController::class,'bomba']);   
    });

    Route::withoutMiddleware(['auth:api','isactive'])->prefix('mongo')->group(function(){
        Route::get('index',[MongoController::class,'index']);
        Route::post('store',[MongoController::class,'store']);
        
    });
});

