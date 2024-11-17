<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'merchant_order_id' => 'string|max:10',
            'recipient_name' => 'required|min:5|max:10',
            'recipient_phone' => [
                'required',
                'regex:/^(01)[3-9][0-9]{8}$/',
                'min:11',
                'max:13',
            ],
            'recipient_address' => 'required|max:20',
            'item_quantity' => 'integer|max:20|required',
            'item_weight' => 'required|numeric',
            'amount_to_collect' => 'integer|required',
            'item_description' => 'required|max:100',
        ];
    }
}
