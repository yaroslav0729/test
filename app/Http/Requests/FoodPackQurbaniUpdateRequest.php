<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodPackQurbaniUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id|unique:food_packs_qurbanies_prices,country_id,'.$this->foodpack_qurbany,
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
