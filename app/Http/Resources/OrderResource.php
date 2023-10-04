<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer->name,
            'customer_address' => $this->customer->address,
            'order_time' => $this->created_at->format('d-m-Y H:i:s'),
            'hotel_name' => $this->hotel->name,
            'hotel_address' => $this->hotel->address,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
