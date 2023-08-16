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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'post_code' => 'required',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email',
            'address_1' => 'required|max:200',
            'address_2' => 'nullable|max:200',
            'city' => 'required|max:100',
            'phone' => 'nullable|max:100',
            'notes' => 'nullable|max:25',
        ];

        foreach ($this->all() as $key => $value) {
            if (strpos($key, 'notes_') === 0) { // changed this line
                $rules[$key] = 'required|max:25'; // add other rules as necessary
            }
        }

        if (!config('app.debug'))
        {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        foreach ($this->all() as $key => $value) {
            if (strpos($key, 'notes_') === 0) {
                $messages[$key . '.required'] = 'This field is required.';
            }
        }

        return $messages;
    }
}
