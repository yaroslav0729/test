<?php

namespace App\Http\Requests;

use App\Models\Page;
use App\Models\Template;
use Illuminate\Foundation\Http\FormRequest;

class PageCreateEditRequest extends FormRequest
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
        $page = $this->route('page');

        if ($page instanceof Page) {
            $slug = 'required|string|max:255|page_slug:' . $page->id;

        } else {
            $slug = 'required|string|max:255|page_slug';
        }

        $rules = [
            'name' => 'required|max:255',
            'template' => 'required|integer|gt:0', // greater than 0
            'slug' => $slug,
            'preview_text' => 'required|max:60',
        ];

        $rules = array_merge($rules, Template::getValidationRules((int)$this->input('template')));

        return $rules;
    }

    public function messages()
    {
        return [
            'slug.page_slug' => 'The slug must be unique to publish',
        ];
    }
}
