<?php

namespace App\Http\Requests\Ingredients\IngredientDetail;

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
            'amount'                         => ['nullable', 'numeric'],
            'amount_max'                     => ['nullable', 'numeric', 'gt:amount'],
            'unit_id'                        => ['nullable', 'exists:units,id'],
            'ingredient_id'                  => ['required', 'exists:ingredients,id'],
            'ingredient_attributes'          => ['nullable', 'array'],
            'ingredient_attributes.*'        => ['required_with:ingredient_attributes', 'exists:ingredient_attributes,id'],
            'ingredient_detail_group_id'     => ['nullable', 'exists:ingredient_detail_groups,id'],
            'ingredient_detail_id'           => ['nullable', 'exists:ingredient_details,id'],
            'position'                       => ['nullable', 'integer'],
        ];
    }
}
