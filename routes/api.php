<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryPersonnelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::group(['prefix' => 'auth'], function () {
//    Route::post('login', [AuthController::class, 'login'])->name('login');
//    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
//    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
//});

Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('orders/restaurants/{restaurant}', [OrderController::class, 'showForRestaurant'])->name('orders.showForRestaurant');
Route::get('orders/all', [OrderController::class, 'allOrders'])->name('orders.all');

Route::get('products/restaurants/{restaurant}', [ProductController::class, 'showForRestaurant'])->name('products.showForRestaurant');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::post('delivery-personnel/mark-status', [DeliveryPersonnelController::class, 'markStatus'])->name('deliveryPersonnel.markStatus');
Route::get('delivery-personnel/get-status/{user_id}', [DeliveryPersonnelController::class, 'getStatus'])->name('deliveryPersonnel.getStatus');

Route::get('restaurants/{city}', [CityController::class, 'showRestaurants'])->name('cities.showRestaurants');
Route::get('items/{city}', [CityController::class, 'showItems'])->name('cities.showItems');

//getting cities list
Route::get('/getCitiesList', [CityController::class,'getCitiesList']);
