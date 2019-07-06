<?php

namespace App\Http\Requests;

use App\Models\Recipe;
use Illuminate\Foundation\Http\FormRequest;

class CreateRecipe extends FormRequest
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
        $complexityTypes = implode('|', array_keys(Recipe::getComplexityTypes()));
        return [
            'name'         => ['required', 'string', 'max:255', 'unique:recipes,name'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['required_with:tags', 'exists:tags,id'],
            'category_id'  => ['required', 'numeric', 'exists:categories,id'],
            'author_id'    => ['required', 'numeric', 'exists:authors,id'],
            'yield_amount' => ['nullable', 'numeric', 'max:999'],
            'complexity'   => ['required', 'string', 'regex:/^('.$complexityTypes.')$/i'],
            'instructions' => ['required', 'string'],
            'photo'        => ['nullable', 'image'],
        ];
    }
}
