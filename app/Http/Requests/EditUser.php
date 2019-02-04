<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class EditUser extends FormRequest
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
            'name'                  => ['required', 'max:255'],
            'email'                 => ['required', 'max:255', 'email', 'unique:users,email,'.Auth::user()->id],
            'current_password'      => ['nullable', 'max:255'],
            'new_password'          => ['nullable', 'required_with:current_password', 'max:255', 'confirmed', 'min:6']
        ];
    }
}
