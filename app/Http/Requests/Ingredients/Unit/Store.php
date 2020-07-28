<?php

namespace App\Http\Requests\Ingredients\Unit;

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
            'name'                 => ['required', 'string', 'max:20', 'unique:units'],
            'name_shortcut'        => ['nullable', 'string', 'max:20'],
            'name_plural'          => ['nullable', 'string', 'max:20'],
            'name_plural_shortcut' => ['nullable', 'string', 'max:20'],
        ];
    }
}
