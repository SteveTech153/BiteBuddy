<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryPersonController;
use App\Http\Controllers\DeliveryPersonnelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('customer.index');
})->name('customer.index');

Auth::routes();

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurant.index');
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurant.create');
    Route::post('/restaurants/store', [RestaurantController::class, 'store'])->name('restaurant.store');
    Route::get('/restaurants/{id}/edit', [RestaurantController::class, 'edit'])->name('restaurant.edit');
    Route::put('/restaurants/{id}/update', [RestaurantController::class, 'update'])->name('restaurant.update');
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy'])->name('restaurant.delete');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/delivery-persons', [DeliveryPersonController::class, 'index'])->name('delivery_person.index');
    Route::get('/delivery-persons/create', [DeliveryPersonController::class, 'create'])->name('delivery_person.create');
    Route::post('/delivery-persons/store', [DeliveryPersonController::class, 'store'])->name('delivery_person.store');
    Route::get('/delivery-persons/{id}/edit', [DeliveryPersonController::class, 'edit'])->name('delivery_person.edit');
    Route::put('/delivery-persons/{id}/update', [DeliveryPersonController::class, 'update'])->name('delivery_person.update');
    Route::delete('/delivery-persons/{id}', [DeliveryPersonController::class, 'destroy'])->name('delivery_person.delete');
});

Route::group(['middleware' => ['auth', 'role:restaurant_owner']], function () {
    Route::get('restaurant-page', function (){
        return view('restaurant-page.index');
    })->name('restaurantPage.index');
    Route::get('restaurant-page/orders', function (){
        return view('restaurant-page.orders');
    })->name('restaurantPage.orders');
    Route::get('restaurant-page/products', function (){
        return view('restaurant-page.products');
    })->name('restaurantPage.products');
    Route::get('restaurant-page/edit', [RestaurantController::class, 'edit'])->name('restaurantPage.edit');
    Route::put('/restaurant-page/{id}/update', [RestaurantController::class, 'updateRestaurant'])->name('restaurantPage.update')->middleware('checkRestaurantOwner');
});

Route::group(['middleware' => ['auth', 'role:delivery_partner']], function () {
    Route::get('delivery-personnel', function (){
        return view('delivery-personnel.index');
    })->name('deliveryPersonnel.index');
    Route::get('delivery-personnel/orders', [DeliveryPersonnelController::class, 'orders'])->name('deliveryPersonnel.orders');
    Route::get('delivery-personnel/accept/{order}', [DeliveryPersonnelController::class, 'accept'])->name('deliveryPersonnel.accept');
    Route::get('delivery-personnel/delivered/{order}', [DeliveryPersonnelController::class, 'delivered'])->name('deliveryPersonnel.delivered');
    Route::get('/delivery-personnel/edit', [DeliveryPersonnelController::class, 'edit'])->name('deliveryPersonnel.edit');
    Route::put('/delivery-personnel/{id}/update', [DeliveryPersonnelController::class, 'updateDeliveryPersonnel'])->name('deliveryPersonnel.update');
});

Route::get('customer/products', function (){
    return view('customer.product');
})->name('customer.product');
Route::get('customer/checkout', function (){
    return view('customer.checkout');
})->name('customer.checkout');
Route::get('restaurant/{restaurant}', [CustomerController::class, 'showRestaurant']);
Route::get('checkout', function () {
    return view('customer.checkout');
})->name('customer.checkout');

Route::group(['middleware' => ['auth', 'role:customer']], function () {
//    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('place-order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('track-order', function () {
        return view('customer.track-order');
    })->name('customer.trackOrder');
    Route::get('get-order-details', [OrderController::class, 'ordersOfCustomer'])->name('orders.ordersOfCustomer');
});

Route::get('current-user', [CustomerController::class, 'currentUser'])->name('currentUser');
