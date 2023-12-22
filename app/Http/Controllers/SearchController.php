<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Product;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $cityName = $request->input('city');
        // Search for hotels and products based on the city and query
        $hotelResults = $this->searchHotels($cityName, $query);
        $productResults = $this->searchProducts($cityName, $query);
        return response()->json([
            'data' => [
                'hotels' => $hotelResults,
                'products' => $productResults,
            ],
        ]);
    }
    private function searchHotels($cityName, $query)
    {
        return Hotel::whereHas('city', function ($queryBuilder) use ($cityName) {
            $queryBuilder->where('name', 'like', "%$cityName%");
        })
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('location', 'like', "%$query%");
            })
            ->with('city') // Eager load the related city data
            ->get();
    }
    private function searchProducts($cityName, $query)
    {
        return Product::whereHas('hotel.city', function ($queryBuilder) use ($cityName) {
            $queryBuilder->where('name', 'like', "%$cityName%");
        })
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            })
            ->with('hotel.city')
            ->get();
    }
}