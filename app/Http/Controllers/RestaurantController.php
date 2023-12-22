<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('owner')->paginate(10);
        return view('restaurant.index', compact('restaurants'));
    }
    public function create()
    {
        return view('restaurant.create');
    }

    public function store(Request $request)
    {
        $restaurantOwner = User::create([
            'name' => $request->input('owner_name'),
            'email' => $request->input('owner_email'),
            'password' => bcrypt('password'),
        ]);

        $restaurantOwner->assignRole('restaurant_owner');
        $restaurant = new Restaurant([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'opening_time' => $request->input('opening_time'),
            'closing_time' => $request->input('closing_time'),
            'city_id' => $request->input('city_id'),
            'image' => $request->input('image'),
        ]);
        $restaurant->user_id = $restaurantOwner->id;

        $restaurant->save();

        return redirect()->route('restaurant.index');
    }

    public function edit()
    {
        $restaurant = Restaurant::with('owner')->findOrFail(auth()->user()->restaurant->id);
        $restaurantOwner = $restaurant->owner;
        return view('restaurant-page.edit', compact('restaurant', 'restaurantOwner'));
    }

    
    public function update(Request $request, $id)
    {

        $restaurant = Restaurant::with('owner')->findOrFail($id);
        $restaurant->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'opening_time' => $request->input('opening_time'),
            'closing_time' => $request->input('closing_time'),
            'city_id' => $request->input('city_id'),
            'image' => $request->input('image'),
        ]);
        return redirect()->route('restaurant.index');
    }

    public function updateRestaurant(Request $request, $id)
    {

        $restaurant = Restaurant::with('owner')->findOrFail($id);
        $restaurant->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'opening_time' => $request->input('opening_time'),
            'closing_time' => $request->input('closing_time'),
            'city_id' => $request->input('city_id'),
            'image' => $request->input('image'),
        ]);
        return redirect()->route('restaurantPage.index')->with('success', 'Restaurant updated successfully');
    }


    public function destroy($id)
    {
        $restaurant = Restaurant::with('owner')->findOrFail($id);
        $restaurantOwner= $restaurant->owner;
        $restaurantOwner->delete();
        $restaurant->delete();
        return redirect()->route('restaurant.index');
    }

}
