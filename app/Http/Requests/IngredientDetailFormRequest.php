<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientDetailFormRequest extends FormRequest
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
            'amount'                    => ['nullable', 'numeric'],
            'amount_max'                => ['nullable', 'numeric'],
            'unit'                      => ['nullable', 'string'],
            'ingredient'                => ['required', 'string'],
            'prep'                      => ['nullable', 'string'],
            'position'                  => ['nullable', 'numeric'],
            'ingredient_detail_group'   => ['nullable', 'string'],
            'ingredient_detail_id'      => ['nullable', 'string'],
        ];
    }
}
