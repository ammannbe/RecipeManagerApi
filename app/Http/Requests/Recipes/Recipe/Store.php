<?php

namespace App\Http\Requests\Recipes\Recipe;

use App\Models\Recipes\Recipe;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Recipes\TagController;
use App\Http\Controllers\Recipes\CookbookController;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'category_id'      => ['required', 'nullable', 'exists:categories,id'],
            'name'             => ['required', 'string', 'max:100', 'unique:recipes,name'],
            'yield_amount'     => ['required', 'nullable', 'numeric', 'max:999'],
            'complexity'       => ['required', 'string', Rule::in(Recipe::COMPLEXITY_TYPES)],
            'instructions'     => ['nullable', 'string', 'max:16000000'],
            'photo'            => ['nullable', 'image'],
            'preparation_time' => ['nullable', 'string', 'date_format:H:i'],
        ];

        if (CookbookController::isEnabled()) {
            array_merge($rules, ['filter.cookbook_id' => ['exists:cookbooks,id']]);
        }

        if (TagController::isEnabled()) {
            array_merge(
                $rules,
                [
                    'tags'   => ['nullable', 'array'],
                    'tags.*' => ['required_with:tags', 'exists:tags,id']
                ]
            );
        }

        return $rules;
    }
}
