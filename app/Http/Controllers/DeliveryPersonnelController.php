<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPersonnel;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class DeliveryPersonnelController extends  Controller
{
    public function orders(){
        $orders = Order::with('restaurant', 'products', 'customer')
            ->where('delivery_id', auth()->user()->id)
            ->where('status', '!=', 'delivered')
            ->get();
        return view('delivery-personnel.order', compact('orders'));
    }
    public function accept($order_id){
        $order = Order::find($order_id);
        $order->update([
            'status' => 'in_progress',
            'delivery_id' => auth()->user()->id,
        ]);

        return redirect()->route('deliveryPersonnel.orders');
    }

    public function delivered($order_id){
        $order = Order::find($order_id);
        $order->update([
            'status' => 'delivered',
        ]);
        $delivery_personnel = DeliveryPersonnel::find(auth()->user()->id);
        $delivery_personnel->update([
            'status' => 'online',
        ]);
        return redirect()->route('deliveryPersonnel.index')->with('success', 'Thank you for delivering the order!');
    }

    // three statuses like offline, online, busy comes with name as status in post
    public function markStatus(Request $request){
        $user_id = $request->user_id;
        $delivery_personnel = DeliveryPersonnel::firstOrCreate([
            'id' => $user_id,
        ]);
        $delivery_personnel->update([
            'status' => $request->status,
        ]);
        return response()->json('Status updated successfully');
    }

    public function getStatus($user_id){
        // if the user is not found and if the status is offline then return offline. else return the status of the user
        $user = DeliveryPersonnel::find($user_id);
        if($user == null){
            return response()->json('offline');
        }
        else{
            $orders = Order::with('restaurant', 'products', 'customer')
                ->where('delivery_id', $user_id)
                ->where('status', '!=', 'delivered')
                ->get();
            if(count($orders) > 0){
                $user->status = 'busy';
                $user->save();
            }
            return response()->json($user->status);
        }
    }
    public function edit(){
        $delivery_personnel = User::find(auth()->user()->id);
        return view('delivery-personnel.edit', compact('delivery_personnel'));
    }
    public function updateDeliveryPersonnel(Request $request, $id)
    {
        if($id!==auth()->user()->id){
            return redirect()->route('deliveryPersonnel.index')->with('error', 'You are not authorized to update this user');
        }
        $delivery_personnel = User::find($id);
        $delivery_personnel->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('deliveryPersonnel.index')->with('success', 'Delivery Personnel updated successfully');
    }
}