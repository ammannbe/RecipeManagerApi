<?php

namespace App\Http\Requests\Ingredients\IngredientGroup;

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
            'name'      => ['required', 'string', 'max:20', "unique:ingredient_groups,name,NULL,NULL,recipe_id,{$this->recipe->id}"],
        ];
    }
}
