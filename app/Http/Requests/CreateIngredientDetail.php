<?php

namespace App\Http\Requests;

use App\IngredientDetail;
use Illuminate\Foundation\Http\FormRequest;

class CreateIngredientDetail extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', [IngredientDetail::class, $this->recipe]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'                    => ['nullable', 'numeric', 'max:99999999.99'],
            'unit'                      => ['nullable', 'string', 'exists:units,name'],
            'ingredient'                => ['required', 'string', 'exists:ingredients,name'],
            'preps'                     => ['nullable', 'array'],
            'preps.*'                   => ['required_with:preps', 'exists:preps,id'],
            'position'                  => ['nullable', 'numeric'],
            'ingredient_detail_group'   => ['nullable', 'string'],
            'ingredient_detail_id'      => ['nullable', 'numeric'],
        ];
    }
}
