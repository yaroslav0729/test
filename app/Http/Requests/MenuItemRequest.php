<?php

namespace App\Http\Requests;

use App\Services\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuItemRequest extends FormRequest
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
        /** @var Menu $menuService */
        $menuService = resolve(Menu::class);

        $menuItem = $this->route('menuItem');
        $parent = $this->route('parent');

        $menuDestination = $menuItem->destination ?? $parent->destination ?? $menuService->getMenuDestination($this->route()->parameters['menuSlug']);
        $isGroup = $this->is_group ?? $menuItem->is_group ?? false;

        $isAdditional = $menuService->isMenuAdditional($menuDestination);
        $textValues = $menuService->getPredefinedTextValuesList($menuDestination);

        return array_merge(
            [
                'text' => array_merge(['required'], !empty($textValues) ? [ Rule::in(array_keys($textValues)) ] : []),
            ], 
            !$isGroup ? [ 'link' => 'required' ] : [],
            $menuItem || $isAdditional ? [] : [ 'is_group' => 'nullable|boolean' ]
        );
    }
}
