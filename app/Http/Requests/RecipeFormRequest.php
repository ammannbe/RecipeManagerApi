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
            'name'          => ['required'],
            'cookbook_id'   => ['required', 'integer'],
            'author_id'     => ['required', 'integer'],
            'yield_amount'  => ['integer'],
            'instructions'  => ['required'],
            'photo'         => ['image', 'nullable'],
        ];
    }
}
