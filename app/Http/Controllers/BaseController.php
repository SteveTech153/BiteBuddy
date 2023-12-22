<?php
namespace App\Http\Controllers;
use App\Models\Restaurant;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Product;
use App\Models\Hotel;
class  BaseController extends Controller
{
    public function show(Request $request, $city = null, $hotelName = null)
    {
        if ($city && $hotelName) {
            $city = City::where('name', $city)->first();
            $hotel = Restaurant::where(['city_id'=>$city->id, 'name'=>$hotelName])->first();
            $products = Product::where('restaurant_id', $hotel->id)->get();
//             return response($products);
            // Both city and hotel_name are provided
            return view('customer.hotel')->with(['products'=>$products, 'city' => $city, 'hotelName' => $hotelName]);
        } elseif ($city) {
            // if comes with search query param
            $city = City::where('name', $city)->first();
            if (!$city) {
                // Handle the case where the city name is not found, e.g., show an error message or redirect
                return redirect()->route('home');
            }
            $hotels = Hotel::where('city_id', $city->id)->get();
            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $hotels = $hotels->whereHas('products', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%$searchTerm%");
                })
                    ->with(['products' => function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%$searchTerm%")
                            ->select('hotel_id', 'name', 'price', 'image')
                            ->orderBy('price', 'asc')
                            ->limit(1);
                    }])
                    ->get();
                if ($hotels->isEmpty()) {
                    // Handle the case where no matches are found
                    return response()->json(['message' => 'No matching hotels found.'], 404);
                }
                return view('customer.hotels')->compact("hotels");
            }
            //if city only specified in the url
            $data = $hotels->map(function ($hotel)  {
                $product = Product::where('hotel_id', $hotel->id)
                    ->orderBy('price', 'asc')
                    ->first();
                return [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                    'city' => $hotel->city,
                    'products' => $product ? [
                        [
                            'hotel_id' => $product->hotel_id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'image' => $product->image,
                        ]
                    ] : [],
                ];
            });
//            return Response($data);
            // Pass the data to the view
            return view('customer.hotels', ["hotels"=>$data,"city"=>$city->name]);
        } else {
            // Neither city nor hotel_name is provided
            return view('customer.index');
        }
    }
}