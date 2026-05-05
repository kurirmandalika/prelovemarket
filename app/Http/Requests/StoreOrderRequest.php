<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        $product = $this->route('product');

        return $product instanceof Product
            && $this->user() !== null
            && $product->status === 'available'
            && $product->user_id !== $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'shipping_address' => ['required', 'string', 'min:10', 'max:1000'],
            'expedition' => ['required', Rule::in(array_keys(Order::EXPEDITIONS))],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
