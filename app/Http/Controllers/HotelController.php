<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('owner')->paginate(10); 
        return view('hotels.index', compact('hotels'));
    }
    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $hotelOwner = User::create([
            'name' => $request->input('owner_name'),
            'email' => $request->input('owner_email'),
            'password' => bcrypt('password'),
        ]);

        $hotelOwner->assignRole('hotel_owner');
        $hotel = new Hotel([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'area' => $request->input('area'),
            'phone' => $request->input('phone'),
            'opening_time' => $request->input('opening_time'),
            'closing_time' => $request->input('closing_time'),
        ]);
        $hotel->user_id = $hotelOwner->id;

        $hotel->save();

        return redirect()->route('hotel.index');
    }

    public function edit($id)
    {
        $hotel = Hotel::with('owner')->findOrFail($id);
        $hotelOwner = $hotel->owner;
        return view('hotels.edit', compact('hotel', 'hotelOwner'));
    }

    
    public function update(Request $request, $id)
    {
        
        $hotel = Hotel::with('owner')->findOrFail($id);
        $hotel->owner->update([
            'name' => $request->input('owner_name'),
            'email' => $request->input('owner_email'),
        ]);

        $hotel->update([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'area' => $request->input('area'),
            'phone' => $request->input('phone'),
            'opening_time' => $request->input('opening_time'),
            'closing_time' => $request->input('closing_time'),
        ]);
       

        return redirect()->route('hotel.index');
    }

    public function destroy($id)
    {
        $hotel = Hotel::with('owner')->findOrFail($id);
        $hotelOwner= $hotel->owner;
        $hotelOwner->delete();
        $hotel->delete();
        return redirect()->route('hotel.index');
    }

}
