<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\DeliveryPersonnel;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function store(StoreOrderRequest $request)
    {
        // Create the order
        $order = new Order();
        $order->customer_id = Auth()->user()->id;
        $order->total_amount = $request->input('totalPrice');
        $order->address = $request->input('address');
        $order->restaurant_id = $request->input('restaurantId');

        // Check for available delivery personnel
        $deliveryPersonnel = DeliveryPersonnel::where('status', 'online')->first();

        if ($deliveryPersonnel) {
            $order->delivery_id = $deliveryPersonnel->id;
            $order->status = 'confirmed';
        } else {
            $order->status = 'pending';
        }

        $order->save();

        // Store the order products
        $items = json_decode($request->input('items'), true);

        foreach ($items as $item) {
            $orderProduct = new Order_Product();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $item['itemId'];
            $orderProduct->quantity = $item['quantity'];
            $orderProduct->save();
        }
        if ($deliveryPersonnel) {
            $deliveryPersonnel->status = 'busy';
            $deliveryPersonnel->save();
        }

        return redirect()->route('customer.trackOrder');
    }


    public function update(StoreOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
    public function showForRestaurant($restaurant_id)
    {
        $orders = Order::with('customer', 'products')
            ->where('restaurant_id', $restaurant_id)
            ->where('status', '!=', 'delivered')
            ->where('status', '!=', 'cancelled')
            ->get();

        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }

    public function allOrders()
    {
        $orders = Order::with('customer', 'products', 'restaurant')
            ->get()
            ->where('status', '==', 'confirmed')
            ->sortByDesc('created_at');

        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }

    public function ordersOfCustomer()
    {
        $orders = Order::with('customer', 'products', 'orderProducts', 'restaurant', 'deliveryPersonnel')
            ->where('customer_id', auth()->user()->id)
            ->whereNotIn('status', ['delivered', 'cancelled'])
            ->get()
            ->sortByDesc('created_at');
        if($orders->isEmpty()){
            $orders = Order::with('customer', 'products', 'orderProducts', 'restaurant', 'deliveryPersonnel')
                ->where('customer_id', auth()->user()->id)
                ->get()
                ->sortByDesc('created_at');
        }
        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }



}
