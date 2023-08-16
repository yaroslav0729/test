<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodPackPagesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page_url' => 'required|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
