<?php

namespace App\Http\Requests;

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
        return [
            'name'         => ['required', 'string', 'max:255', 'unique:recipes,name'],
            'category_id'  => ['required', 'string', 'exists:categories,id'],
            'author_id'    => ['required', 'string', 'exists:authors,id'],
            'yield_amount' => ['nullable', 'numeric', 'max:999'],
            'instructions' => ['required', 'string'],
            'photo'        => ['nullable', 'image'],
        ];
    }
}
