<?php

namespace App\Http\Requests\Users\User;

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
        $user = $this->user ?? auth()->user();

        return [
            'name'  => ['string', 'max:255', "unique:authors,name,{$user->author->id}"],
            'email' => ['email', 'max:255', "unique:users,email,{$user->id}"],
        ];
    }
}
