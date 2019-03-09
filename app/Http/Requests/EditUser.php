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
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'max:255', 'email', 'unique:users,email,'.auth()->user()->id],
            'current_password' => ['nullable', 'string', 'max:255'],
            'new_password'     => ['nullable', 'string', 'max:255', 'min:6', 'required_with:current_password', 'confirmed'],
        ];
    }
}
