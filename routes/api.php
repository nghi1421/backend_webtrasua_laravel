<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;

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
Route::prefix('/admin')->group( function () {
    Route::middleware('auth:sanctum')->group(function (){
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout',[AuthController::class, 'logout']);

        Route::apiResource('/staffs', StaffController::class);

    });
    
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

});


Route::post('/login-customer',[AuthController::class, 'loginCustomer']);


Route::get('/testing-deploy',function(){
    return 'Hello Tu';
});
