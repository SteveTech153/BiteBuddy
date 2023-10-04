<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|integer',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1',
            'customer_address.flat_no' => 'required|string',
            'customer_address.street' => 'required|string',
            'customer_address.state' => 'required|string',
            'customer_address.pincode' => 'required|string',
        ];
    }
}
