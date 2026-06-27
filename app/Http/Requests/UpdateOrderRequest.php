<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['sometimes', new Enum(OrderStatus::class)],

            'items' => ['sometimes', 'array', 'min:1'],

            'items.*.product_name' => [
                'required_with:items',
                'string',
                'max:255',
            ],

            'items.*.quantity' => [
                'required_with:items',
                'integer',
                'min:1',
            ],

            'items.*.price' => [
                'required_with:items',
                'numeric',
                'min:0.01',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'items.array' => 'Items must be an array.',
            'items.min' => 'Order must contain at least one item.',

            'items.*.product_name.required_with' => 'Product name is required.',
            'items.*.quantity.required_with' => 'Quantity is required.',
            'items.*.price.required_with' => 'Price is required.',
        ];
    }
}
