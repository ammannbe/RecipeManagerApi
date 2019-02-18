<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeFormRequest extends FormRequest
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
            'name'              => ['required', 'string'],
            'cookbook'          => ['required', 'string'],
            'author'            => ['nullable', 'string'],
            'yield_amount'      => ['nullable', 'numeric'],
            'yield_amount_max'  => ['nullable', 'numeric'],
            'instructions'      => ['required', 'string'],
            'photo'             => ['nullable', 'image'],
        ];
    }
}
