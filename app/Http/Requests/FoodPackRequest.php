<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodPackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id|unique:food_packs_prices,country_id',
            'price' => 'required|numeric',
            'campaign_name' => 'nullable|string|max:255',
            'project_name' => 'nullable|string|max:255',
            'program_name' => 'nullable|string|max:255',
            'campaign_category_id' => 'nullable|exists:campaign_categories,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
