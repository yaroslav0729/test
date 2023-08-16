<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodPackUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id|unique:food_packs_prices,country_id,'.$this->foodpack,
            'price' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
