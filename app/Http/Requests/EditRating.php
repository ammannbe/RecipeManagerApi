<?php

namespace App\Http\Requests;

use App\Rating;
use Illuminate\Foundation\Http\FormRequest;

class EditRating extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', [Rating::class, $this->rating]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating_criterion' => ['required', 'string', 'exists:rating_criteria,name'],
            'comment'          => ['required', 'string'],
            'stars'            => ['nullable', 'numeric', 'min:1', 'max:5'],
        ];
    }
}
