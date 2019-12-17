<?php

namespace App\Http\Requests\Ratings\Rating;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'criterion_id' => ['exists:rating_criteria'],
            'comment'      => ['string', 'max:60000'],
            'stars'        => ['nullable', 'integer', 'max:5'],
        ];
    }
}
