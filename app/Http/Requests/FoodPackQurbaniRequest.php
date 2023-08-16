<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodPackQurbaniRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id|unique:food_packs_qurbanies_prices,country_id',
            'prices' => 'required|array',
            'prices.*' => 'numeric',
            'types' => 'required|array',
            'types.*' => 'numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
