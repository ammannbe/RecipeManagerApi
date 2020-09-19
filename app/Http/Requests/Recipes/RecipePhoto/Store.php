<?php

namespace App\Http\Requests\Recipes\RecipePhoto;

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
            'photos'   => ['required', 'array', 'max:20'],
            'photos.*' => ['required', 'image'],
        ];
    }
}
