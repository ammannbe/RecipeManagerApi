<?php

namespace App\Http\Requests;

use App\Rating;
use Illuminate\Foundation\Http\FormRequest;

class CreateRating extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', [Rating::class, $this->recipe]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating_criterion_id' => ['required', 'string', 'exists:rating_criteria,id'],
            'comment'             => ['required', 'string'],
            'stars'               => ['nullable', 'numeric', 'min:1', 'max:5'],
        ];
    }
}
