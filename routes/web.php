<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryPersonController;
use App\Http\Controllers\DeliveryPersonnelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotel.index');
    Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/hotels/store', [HotelController::class, 'store'])->name('hotel.store');
    Route::get('/hotels/{id}/edit', [HotelController::class, 'edit'])->name('hotel.edit');
    Route::put('/hotels/{id}/update', [HotelController::class, 'update'])->name('hotel.update');
    Route::delete('/hotels/{id}', [HotelController::class, 'destroy'])->name('hotel.delete');
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

Route::group(['middleware' => ['auth', 'role:hotel_owner']], function () {
    Route::get('hotel-page', function (){
        return view('hotel-page.index');
    })->name('hotelPage.index');
    Route::get('hotel-page/orders', function (){
        return view('hotel-page.orders');
    })->name('hotelPage.orders');
    Route::get('hotel-page/products', function (){
        return view('hotel-page.products');
    })->name('hotelPage.products');
});

Route::group(['middleware' => ['auth', 'role:delivery_partner']], function () {
    Route::get('delivery-personnel', function (){
        return view('delivery-personnel.index');
    })->name('deliveryPersonnel.index');
    Route::get('delivery-personnel/orders', [DeliveryPersonnelController::class, 'orders'])->name('deliveryPersonnel.orders');
    Route::get('delivery-personnel/accept/{order}', [DeliveryPersonnelController::class, 'accept'])->name('deliveryPersonnel.accept');
    Route::get('delivery-personnel/delivered/{order}', [DeliveryPersonnelController::class, 'delivered'])->name('deliveryPersonnel.delivered');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});