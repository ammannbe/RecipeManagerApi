<?php

namespace App\Http\Requests;

use App\Models\IngredientDetail;
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
            'amount'                     => ['nullable', 'numeric', 'max:99999999.99'],
            'unit_id'                    => ['nullable', 'string', 'exists:units,id'],
            'ingredient_id'              => ['required', 'string', 'exists:ingredients,id'],
            'preps'                      => ['nullable', 'array'],
            'preps.*'                    => ['required_with:preps', 'exists:preps,id'],
            'position'                   => ['nullable', 'numeric'],
            'ingredient_detail_group_id' => ['nullable', 'numeric', 'exists:ingredient_detail_group,id'],
            'ingredient_detail_id'       => ['nullable', 'numeric', 'exists:ingredient_details,id'],
        ];
    }
}
