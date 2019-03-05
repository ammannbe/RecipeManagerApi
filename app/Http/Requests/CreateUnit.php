<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUnit extends FormRequest
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
            'name'                 => ['required', 'string'],
            'name_shortcut'        => ['nullable', 'string'],
            'name_plural'          => ['nullable', 'string'],
            'name_plural_shortcut' => ['nullable', 'string'],
        ];
    }
}
