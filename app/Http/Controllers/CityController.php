<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\City;
class CityController extends Controller
{
    public function getCitiesList()
    {
        $cities = City::pluck('name');
        return response()->json($cities);
    }
    public function showRestaurants($city)
    {
        $city = City::where('name', $city)->first();
        $restaurants = $city->restaurants;
        return response()->json($restaurants);
    }
}