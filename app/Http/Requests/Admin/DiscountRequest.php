<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:255',
            'discount_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'minimum_purchase' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ];
    }
}
