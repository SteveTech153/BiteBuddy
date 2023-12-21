<?php

namespace App\Jobs;

use App\Models\DeliveryPersonnel;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignDeliveryPersonnel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $orders = Order::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        if ($orders->count() === 0) {
            return;
        }
        foreach ($orders as $order) {
            $deliveryPersonnel = DeliveryPersonnel::where('status', 'online')->first();
            if ($deliveryPersonnel) {
                $order->delivery_id = $deliveryPersonnel->id;
                $order->status = 'confirmed';
                $order->save();
                $deliveryPersonnel->status = 'busy';
                $deliveryPersonnel->save();
                SendOrderConfirmedMail::dispatch($order);
            }
        }
    }
}
