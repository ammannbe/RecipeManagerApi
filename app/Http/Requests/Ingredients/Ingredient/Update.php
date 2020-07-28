<?php

namespace App\Http\Requests\Ingredients\Ingredient;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'amount'                         => ['nullable', 'numeric'],
            'amount_max'                     => ['nullable', 'numeric', 'gt:amount'],
            'unit_id'                        => ['nullable', 'exists:units,id'],
            'food_id'                        => ['exists:foods,id'],
            'ingredient_attributes'          => ['nullable', 'array'],
            'ingredient_attributes.*'        => ['required_with:ingredient_attributes', 'exists:ingredient_attributes,id'],
            'ingredient_group_id'            => ['nullable', 'exists:ingredient_groups,id'],
            'ingredient_id'                  => ['nullable', 'exists:ingredients,id'],
            'position'                       => ['nullable', 'integer'],
        ];
    }
}
