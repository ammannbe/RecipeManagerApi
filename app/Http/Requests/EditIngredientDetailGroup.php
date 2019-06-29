<?php

namespace App\Http\Requests;

use App\Models\IngredientDetailGroup;
use Illuminate\Foundation\Http\FormRequest;

class EditIngredientDetailGroup extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', [IngredientDetailGroup::class, $this->recipe]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:10', 'unique:ingredient_detail_groups,name,NULL,recipe_id,recipe_id,'.$this->recipe->id],
        ];
    }
}
