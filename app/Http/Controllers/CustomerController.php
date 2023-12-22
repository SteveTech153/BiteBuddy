<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('customer.index', compact('restaurants'));
    }
    public function showRestaurant($restaurant)
    {
        // if data inside restaurant is numeric, then use id, else use name
        if (is_numeric($restaurant)) {
            $restaurant = Restaurant::find($restaurant);
        } else {
            $restaurant = Restaurant::where('name', $restaurant)->first();
        }
        $products = $restaurant->products;
        return view('customer.restaurant', compact('products', 'restaurant'));
    }
    public function currentUser(){
        if(Auth::check()){
            return response()->json(['message' => 'yes']);
        }else{
            return response()->json(['message' => 'no']);
        }
    }
}
