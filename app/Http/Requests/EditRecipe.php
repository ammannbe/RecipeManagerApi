<?php

namespace App\Http\Requests;

use App\Models\Recipe;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditRecipe extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', [Recipe::class, $this->recipe]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => ['required', 'string', 'max:255', 'unique:recipes,name,' . $this->recipe->id],
            'category_id'      => ['required', 'numeric', 'exists:categories,id'],
            'tags'             => ['nullable', 'array'],
            'tags.*'           => ['required_with:tags', 'exists:tags,id'],
            'author_id'        => ['required', 'string', 'exists:authors,id'],
            'yield_amount'     => ['nullable', 'numeric', 'max:999'],
            'complexity'       => ['required', 'string', Rule::in(array_keys(Recipe::getComplexityTypes()))],
            'instructions'     => ['required', 'string'],
            'preparation_time' => ['nullable', 'string'],
            'photo'            => ['nullable', 'image'],
        ];
    }
}
