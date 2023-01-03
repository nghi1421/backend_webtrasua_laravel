<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\SupplyVoucherController;
use App\Http\Controllers\ImportVoucherController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ShippingProviderController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChefController;




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
        Route::get('/positions',[StaffController::class, 'getPosition']);

        Route::apiResource('/customers', CustomerController::class);
        Route::post('/customers/active/{id}', [CustomerController::class, 'active']);
        Route::post('/customers/inactive/{id}', [CustomerController::class, 'inActive']);
        Route::post('/customers/{id}/add-address', [CustomerController::class, 'addNewAddress']);

        Route::apiResource('/branches', BranchController::class);
        Route::post('/branches/active/{id}', [BranchController::class, 'active']);
        Route::post('/branches/inactive/{id}', [BranchController::class, 'inActive']);

        Route::apiResource('/warehouses', WarehouseController::class);
        Route::post('/warehouses/active/{id}', [WarehouseController::class, 'active']);
        Route::post('/warehouses/inactive/{id}', [WarehouseController::class, 'inActive']);

        Route::apiResource('/materials', MaterialController::class);
        Route::get('/get-materials', [MaterialController::class, 'getAllMaterial']);

        Route::apiResource('/drinks', DrinkController::class);
        Route::post('/drinks/active/{id}', [DrinkController::class, 'active']);
        Route::post('/drinks/inactive/{id}', [DrinkController::class, 'inActive']);

        Route::apiResource('/supplyvouchers', SupplyVoucherController::class);

        Route::apiResource('/importvouchers', ImportVoucherController::class);

        Route::apiResource('/orders', OrderController::class);


        Route::apiResource('/sizes', SizeController::class);

        Route::apiResource('/providers', ProviderController::class);

        Route::get('/get-all-providers', [ProviderController::class, 'getAllProviders']);

        Route::delete('/toppings/{id}',[ToppingController::class, 'remove']);
        Route::put('/toppings/{id}',[ToppingController::class, 'update']);
        Route::post('/toppings',[ToppingController::class, 'create']);

        Route::apiResource('/users', UserController::class);
        Route::get('/roles', [UserController::class, 'getAllRole']);
        Route::post('/users/reset-password/{id}', [UserController::class, 'setDefaultPassword']);
        

    });
    
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

});


Route::prefix('/chef')->group(function (){
    Route::middleware("auth:sanctum")->group(function (){
        Route::get('/order-queue-confirmed', [ChefController::class, 'getQueueOrdersConfirmed']);
        Route::get('/order-queue-preparing', [ChefController::class, 'getQueueOrdersPreparing']);
        Route::get('/order-status', [ChefController::class, 'getAllOrderStatus']);
        
    });

});

Route::apiResource('/shippingproviders', ShippingProviderController::class);

Route::get('/type-of-drinks', [DrinkController::class, 'getAllTypeOfDrink']);


// Route::middleware('auth:sanctum')->group(function (){
//     Route::get('/drinks', [DrinkController::class, 'getAllDrinks']);
// });

Route::get('/drinks', [DrinkController::class, 'getAllDrinks']);
Route::get('/drinks-by-typeofdrink-id/{tod_id}', [DrinkController::class, 'getDrinkByTypeOfDrink']);
Route::get('/sizes', [DrinkController::class, 'getAllSize']);

// Route::get('/drinks/search', [DrinkController::class, 'searchFullText']);

Route::post('/login-customer',[AuthController::class, 'loginCustomer']);
Route::post('/customer/otp-authentication',[AuthController::class, 'getCustomerThroughtOTP']);
Route::post('/add-new-customer',[AuthController::class, 'addCustomer']);

Route::post('/orders/get-list-predict', [OrderController::class, 'predictValues']);

Route::get('/testing-deploy',function(){
    return 'Hello Tu';
});
