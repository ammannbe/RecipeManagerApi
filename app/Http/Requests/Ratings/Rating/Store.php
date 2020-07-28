<?php

namespace App\Http\Requests\Ratings\Rating;

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
            'recipe_id'    => ['required', 'exists:recipes,id'],
            'criterion_id' => ['required', 'exists:rating_criteria'],
            'comment'      => ['required', 'string', 'max:60000'],
            'stars'        => ['required', 'nullable', 'integer', 'max:5'],
        ];
    }
}
