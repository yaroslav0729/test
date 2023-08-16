<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CampaignCreateEditRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'country_id' => 'required',
            'prices' => 'page_prices',
            'prices_new' => 'page_prices'
        ];
    }

    public function messages()
    {
        return [
            'prices_new.page_prices' => 'Enter value for all prices',
        ];
    }
}
