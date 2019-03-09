<?php

namespace App\Http\Requests;

use App\Recipe;
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
            'name'             => ['required', 'string', 'max:255', 'unique:recipes,name,'.$this->recipe->id],
            'cookbook'         => ['required', 'string', 'exists:cookbooks,name'],
            'category'         => ['required', 'string', 'exists:categories,name'],
            'author'           => ['required', 'string', 'exists:authors,name'],
            'yield_amount'     => ['nullable', 'numeric', 'max:999'],
            'instructions'     => ['required', 'string'],
            'preparation_time' => ['nullable', 'string'],
            'photo'            => ['nullable', 'image'],
        ];
    }
}
