<?php

namespace App\Http\Requests\Recipes\Recipe;

use App\Models\Recipes\Recipe;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'cookbook_id'      => ['nullable', 'exists:cookbooks,id'],
            'category_id'      => ['required', 'nullable', 'exists:categories,id'],
            'name'             => ['required', 'string', 'max:255', 'unique:recipes,name'],
            'yield_amount'     => ['required', 'nullable', 'numeric', 'max:999'],
            'complexity'       => ['required', 'string', Rule::in(Recipe::COMPLEXITY_TYPES)],
            'instructions'     => ['nullable', 'string', 'max:16000000'],
            'photo'            => ['nullable', 'image'],
            'preparation_time' => ['required', 'string', 'date_format:H:i'],
            'tags'             => ['nullable', 'array'],
            'tags.*'           => ['required_with:tags', 'exists:tags,id'],
        ];
    }
}
