<?php

namespace App\Http\Requests\Ingredients\Unit;

use App\Http\Requests\FormRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class Index extends FormRequest
{
    use FormRequestRules;

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
            'trashed' => $this->getTrashedRule()
        ];
    }
}
