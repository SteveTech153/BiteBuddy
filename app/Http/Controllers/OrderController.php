<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\DeliveryPersonnel;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }

    public function store(CreateOrderRequest $request)
    {
        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->total_amount = $order->calculateTotalPrice($request->input('products'));
        $order->address = json_encode($request->input('customer_address'));
        $order->save();

        $deliveryPersonnel = DeliveryPersonnel::where('status', 'online')->first();
        if ($deliveryPersonnel) {
            $order->delivery_id = $deliveryPersonnel->id;
            $order->save();

            $response = [
                'order_id' => $order->id,
                'delivery_boy_id' => $deliveryPersonnel->id,
                'status' => 'confirmed',
                'message' => 'Your order has been confirmed and is being prepared for delivery.'
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Sorry, no available delivery person at the moment. Your order will be processed shortly.'
            ];

            return response()->json($response, 200);
        }
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(CreateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
    public function showForHotel($hotel_id)
    {
        $orders = Order::with('customer', 'products')
            ->where('hotel_id', $hotel_id)
            ->where('status', '!=', 'delivered')
            ->where('status', '!=', 'cancelled')
            ->get();

        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }

    public function allOrders()
    {
        $orders = Order::with('customer', 'products', 'hotel')
            ->get()
            ->where('status', '==', 'confirmed')
            ->sortByDesc('created_at');

        return response()->json(['data' => OrderResource::collection($orders)], 200);
    }

}
