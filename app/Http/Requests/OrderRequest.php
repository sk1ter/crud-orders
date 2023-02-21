<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_date' => 'required|date:d.m.Y',
            'phone' => 'nullable|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'address_latitude' => 'nullable|numeric',
            'address_longitude' => 'nullable|numeric',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ];
    }

    protected function prepareForValidation()
    {
        if (!empty($this->input('phone'))) {
            $phone = preg_replace('/\s+/', '', $this->input('phone'));
            $phone = preg_replace('/[^+0-9]/', '', $phone);
            $this->merge([
                'phone' => $phone
            ]);
        }

    }
}
