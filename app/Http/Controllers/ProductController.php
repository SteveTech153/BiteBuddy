<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function showForHotel($hotel_id){
        $products = Product::with('hotel')
            ->where('hotel_id', $hotel_id)
            ->get();
        return response()->json(['data' => ProductResource::collection($products)], 200);
    }
}
