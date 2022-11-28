<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\MaterialController;

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
        Route::post('/staffs/active/{id}', [StaffController::class, 'active']);
        Route::post('/staffs/inactive/{id}', [StaffController::class, 'inActive']);

        Route::apiResource('/customers', CustomerController::class);
        Route::post('/customers/active/{id}', [CustomerController::class, 'active']);
        Route::post('/customers/inactive/{id}', [CustomerController::class, 'inActive']);

        Route::apiResource('/branches', BranchController::class);
        Route::post('/branches/active/{id}', [BranchController::class, 'active']);
        Route::post('/branches/inactive/{id}', [BranchController::class, 'inActive']);

        Route::apiResource('/warehouses', WarehouseController::class);
        Route::post('/warehouses/active/{id}', [WarehouseController::class, 'active']);
        Route::post('/warehouses/inactive/{id}', [WarehouseController::class, 'inActive']);

        Route::apiResource('/materials', MaterialController::class);
    });
    
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

});


Route::post('/login-customer',[AuthController::class, 'loginCustomer']);


Route::get('/testing-deploy',function(){
    return 'Hello Tu';
});
