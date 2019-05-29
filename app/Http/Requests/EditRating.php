<?php

namespace App\Http\Requests;

use App\Models\Rating;
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
            'rating_criterion_id' => ['required', 'string', 'exists:rating_criteria,id'],
            'comment'             => ['required', 'string'],
            'stars'               => ['nullable', 'numeric', 'min:1', 'max:5'],
        ];
    }
}
