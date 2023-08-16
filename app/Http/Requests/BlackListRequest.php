<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlackListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ip' => 'required|ip'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
