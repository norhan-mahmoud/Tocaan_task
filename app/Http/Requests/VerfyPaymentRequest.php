<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class VerfyPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'obj'=>['required', 'array'],
            'obj.payment_method' => ['required', new Enum(PaymentMethod::class)],
            'obj.id' => ['sometimes', 'string'],
            'obj.success' => ['required', 'boolean'],
            'obj.data' => ['sometimes', 'array'],
            'obj.data.captured' => ['sometimes', 'boolean'],
        ];
    }
}
